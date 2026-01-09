<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInicioCargaRequest;
use App\Http\Requests\UpdateInicioCargaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InicioCargaRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\InicioCargaMail;
use Illuminate\Http\Request;
use App\Models\InicioCarga;
use App\Models\Ot;
use Flash;

class InicioCargaController extends AppBaseController
{
    /** @var InicioCargaRepository $inicioCargaRepository*/
    private $inicioCargaRepository;

    public function __construct(InicioCargaRepository $inicioCargaRepo)
    {
        $this->inicioCargaRepository = $inicioCargaRepo;
    }

    /**
     * Display a listing of the InicioCarga.
     */
    public function index(Request $request)
    {
        $inicioCargas = InicioCarga::orderBy('id', 'desc')->paginate(10);

        return view('inicio_cargas.index', compact('inicioCargas'));
    }

    /**
     * Show the form for creating a new InicioCarga.
     */

    public function create(Request $request)
    {
        $ots = Ot::with([
                'cotizacion.solicitud.cliente',
                'vehiculos' => fn ($q) => $q->orderBy('orden')->with('inicioCargas'),
            ])
            ->whereIn('estado', ['pendiente', 'en_transito'])
            ->whereHas('vehiculos', function ($q) {
                $q->whereDoesntHave('inicioCargas');
            })
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($ot) {
                $cliente = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                if (is_null($ot->cliente)) {
                    $ot->cliente = $cliente?->razon_social;
                }

                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }

                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }

                if (is_null($ot->conductor)) {
                    $ot->conductor = optional($ot->cotizacion)->conductor;
                }

                // ✅ Estos son los que usas en la vista (data-telefono / data-correo)
                $ot->contacto          = $cliente?->razon_social;
                $ot->telefono_contacto = $cliente?->telefono ?? '';
                $ot->correo_contacto   = $cliente?->correo   ?? '';

                return $ot;
            });

        $ot = null;

        // ✅ Si viene ot_id, carga TAMBIÉN las relaciones para obtener correo desde cliente
        if ($request->filled('ot_id')) {
            $ot = Ot::with([
                    'cotizacion.solicitud.cliente', // ✅ necesario para $ot->cotizacion->solicitud->cliente->correo
                    'vehiculos' => fn($q) => $q->orderBy('orden')->with('inicioCargas'),
                ])
                ->find($request->get('ot_id'));

            // ✅ Opcional: setear los campos derivados igual que arriba,
            // para que el $ot preseleccionado tenga correo_contacto, etc.
            if ($ot) {
                $cliente = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                if (is_null($ot->cliente)) {
                    $ot->cliente = $cliente?->razon_social;
                }
                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }
                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }
                if (is_null($ot->conductor)) {
                    $ot->conductor = optional($ot->cotizacion)->conductor;
                }

                $ot->contacto          = $cliente?->razon_social;
                $ot->telefono_contacto = $cliente?->telefono ?? '';
                $ot->correo_contacto   = $cliente?->correo   ?? '';
            }
        }

        return view('inicio_cargas.create', compact('ots', 'ot'));
    }

    /**
     * Store a newly created InicioCarga in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ot_id'             => ['required', 'integer', 'exists:ots,id'],
            'ot_vehiculo_id'    => ['nullable', 'integer', 'exists:ot_vehiculos,id'],

            'cliente'           => ['required', 'string', 'max:255'],
            'contacto'          => ['nullable', 'string', 'max:255'],
            'telefono_contacto' => ['nullable', 'string', 'max:50'],
            'correo_contacto'   => ['nullable', 'string', 'max:255'], // lo mantienes si lo usas
            'email_envio'       => ['required', 'email'],             // ✅ NUEVO (editable)

            'origen'            => ['required', 'string', 'max:255'],
            'destino'           => ['required', 'string', 'max:255'],
            'tipo_carga'        => ['nullable', 'string', 'max:255'],
            'peso_aproximado'   => ['nullable', 'string', 'max:255'],
            'fecha_carga'       => ['nullable', 'date'],
            'hora_presentacion' => ['nullable', 'string', 'max:50'],
            'conductor'         => ['nullable', 'string', 'max:255'],
            'observaciones'     => ['nullable', 'string'],

            'foto_1'            => ['nullable', 'image', 'max:4096'],
            'foto_2'            => ['nullable', 'image', 'max:4096'],
            'foto_3'            => ['nullable', 'image', 'max:4096'],
            'foto_guia_despacho'=> ['nullable', 'image', 'max:4096'],
        ]);

        $emailCliente = $data['email_envio'];
        unset($data['email_envio']); // no lo guardes en la tabla (a menos que quieras)

        // Validación de negocio: si OT tiene vehículos, exigir vehículo
        $ot = Ot::with('vehiculos')->findOrFail($data['ot_id']);

        if ($ot->vehiculos->count() > 0 && empty($data['ot_vehiculo_id'])) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Debes seleccionar un vehículo para esta OT.',
            ]);
        }

        // Asegurar que el vehículo pertenece a la OT
        if (!empty($data['ot_vehiculo_id'])) {
            $pertenece = $ot->vehiculos->contains('id', (int) $data['ot_vehiculo_id']);
            if (!$pertenece) {
                return back()->withInput()->withErrors([
                    'ot_vehiculo_id' => 'El vehículo seleccionado no pertenece a la OT.',
                ]);
            }
        }

        // Manejo de archivos (disco 'public')
        if ($request->hasFile('foto_1')) {
            $data['foto_1'] = $request->file('foto_1')->store('inicio_cargas', 'public');
        }
        if ($request->hasFile('foto_2')) {
            $data['foto_2'] = $request->file('foto_2')->store('inicio_cargas', 'public');
        }
        if ($request->hasFile('foto_3')) {
            $data['foto_3'] = $request->file('foto_3')->store('inicio_cargas', 'public');
        }
        if ($request->hasFile('foto_guia_despacho')) {
            $data['foto_guia_despacho'] = $request->file('foto_guia_despacho')->store('inicio_cargas', 'public');
        }

        $exists = \App\Models\InicioCarga::where('ot_id', $data['ot_id'])
            ->where('ot_vehiculo_id', $data['ot_vehiculo_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Este vehículo ya registró inicio de carga para esta OT.',
            ]);
        }

        // Crear inicio de carga
        $inicioCarga = InicioCarga::create($data);

        $ot = Ot::with('vehiculos')->findOrFail($data['ot_id']);
        $ot->estado = 'en_transito';
        $ot->save();

        // ✅ Enviar correo
        $inicioCarga->load('ot');

        Mail::to($emailCliente)
            ->cc(['jgcontador@tjca.cl', 'fhenott@tjca.cl'])
            ->send(new InicioCargaMail($inicioCarga));

        return view('inicio_cargas.success', [
            'success'     => 'Inicio de carga registrado correctamente.',
            'inicioCarga' => $inicioCarga,
        ]);
    }

    /**
     * Display the specified InicioCarga.
     */
    public function show($id)
    {
        $inicioCarga = $this->inicioCargaRepository->find($id);

        if (empty($inicioCarga)) {
            Flash::error('Inicio Carga not found');

            return redirect(route('operacion.inicio-carga.index'));
        }

        return view('inicio_cargas.show')->with('inicioCarga', $inicioCarga);
    }

    /**
     * Show the form for editing the specified InicioCarga.
     */
    public function edit($id)
    {
        $inicioCarga = $this->inicioCargaRepository->find($id);

        if (empty($inicioCarga)) {
            Flash::error('Inicio Carga not found');

            return redirect(route('operacion.inicio-carga.index'));
        }

        return view('inicio_cargas.edit')->with('inicioCarga', $inicioCarga);
    }

    /**
     * Update the specified InicioCarga in storage.
     */
    public function update($id, UpdateInicioCargaRequest $request)
    {
        $inicioCarga = $this->inicioCargaRepository->find($id);

        if (empty($inicioCarga)) {
            Flash::error('Inicio Carga not found');

            return redirect(route('operacion.inicio-carga.index'));
        }

        $inicioCarga = $this->inicioCargaRepository->update($request->all(), $id);

        Flash::success('Inicio Carga updated successfully.');

        return redirect(route('operacion.inicio-carga.index'));
    }

    /**
     * Remove the specified InicioCarga from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $inicioCarga = $this->inicioCargaRepository->find($id);

        if (empty($inicioCarga)) {
            Flash::error('Inicio Carga not found');

            return redirect(route('operacion.inicio-carga.index'));
        }

        $this->inicioCargaRepository->delete($id);

        Flash::success('Inicio Carga deleted successfully.');

        return redirect(route('operacion.inicio-carga.index'));
    }
}
