<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Repositories\EntregaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EntregaRegistradaMail;
use App\Models\Cliente;
use App\Models\Entrega;
use App\Models\Ot;
use App\Models\Conductor;
use Flash;

class EntregaController extends AppBaseController
{
    /** @var EntregaRepository */
    private $entregaRepository;

    public function __construct(EntregaRepository $entregaRepo)
    {
        $this->entregaRepository = $entregaRepo;
    }

    /**
     * Listado (panel interno /operacion/entrega).
     */
    public function index(Request $request)
    {
        $entregas = Entrega::with(['ot', 'otVehiculo'])
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('entregas.index', compact('entregas'));
    }

    /**
     * Formulario público (resource 'entregas') o interno si lo llamas.
     */
    public function create(Request $request)
    {
        $ots = Ot::with([
                'cotizacion.solicitud.cliente',
                'vehiculos' => fn($q) => $q->orderBy('orden')->with('entregas'),
            ])
            ->whereIn('estado', ['en_transito'])
            ->whereHas('vehiculos', function ($q) {
                $q->whereDoesntHave('entregas');
            })
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($ot) {
                $clienteRel = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                // Defaults visuales (si algo viene nulo)
                if (is_null($ot->cliente)) {
                    $ot->cliente = $clienteRel?->razon_social;
                }

                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }

                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }

                // Correo REAL del cliente
                $ot->correo_cliente = $clienteRel?->correo ?? '';

                return $ot;
            });

        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('entregas.create', compact('ots', 'conductores'));
    }

    /**
     * Guardar entrega (se usa tanto en público como en panel).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ot_id'             => ['required', 'integer'],
            'ot_vehiculo_id'    => ['required', 'integer', 'exists:ot_vehiculos,id'],

            'nombre_receptor'   => ['required', 'string', 'max:255'],
            'rut_receptor'      => ['nullable', 'string', 'max:50'],
            'telefono_receptor' => ['nullable', 'string', 'max:50'],
            'correo_receptor'   => ['nullable', 'string', 'max:255'],
            'lugar_entrega'     => ['nullable', 'string', 'max:255'],
            'fecha_entrega'     => ['nullable', 'date'],
            'hora_entrega'      => ['nullable', 'string', 'max:20'],
            'numero_guia'       => ['nullable', 'string', 'max:50'],
            'numero_interno'    => ['nullable', 'string', 'max:50'],
            'conforme'          => ['nullable', 'boolean'],
            'observaciones'     => ['nullable', 'string'],

            'foto_1' => ['nullable', 'image', 'max:10240'],
            'foto_2' => ['nullable', 'image', 'max:10240'],
            'foto_3' => ['nullable', 'image', 'max:10240'],
            'foto_guia_despacho' => ['nullable', 'image', 'max:10240'],

            // ✅ nuevo
            'email_envio' => ['required', 'email', 'max:255'],
        ]);

        $data['conforme'] = $request->has('conforme') ? (bool) $request->conforme : null;

        // OT + cliente
        $ot = Ot::with('cotizacion.solicitud.cliente', 'vehiculos.entregas')->findOrFail($request->ot_id);

        $data['cliente'] = optional($ot->cotizacion)->cliente ?? 'SIN CLIENTE';

        if ($request->filled('conductor_id')) {
            $data['conductor'] = Conductor::find($request->conductor_id)?->nombre;
        }

        foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
            if ($request->hasFile($campo) && $request->file($campo)->isValid()) {
                $data[$campo] = $request->file($campo)->store('entregas', 'public');
            }
        }

        if ($request->hasFile('foto_guia_despacho') && $request->file('foto_guia_despacho')->isValid()) {
            $data['foto_guia_despacho'] = $request->file('foto_guia_despacho')->store('entregas', 'public');
        }

        // pertenencia
        if (!$ot->vehiculos->contains('id', (int) $data['ot_vehiculo_id'])) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'El vehículo seleccionado no pertenece a la OT.',
            ]);
        }

        // evitar duplicado
        $yaExiste = Entrega::where('ot_id', $data['ot_id'])
            ->where('ot_vehiculo_id', $data['ot_vehiculo_id'])
            ->exists();

        if ($yaExiste) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Este vehículo ya registró entrega para esta OT.',
            ]);
        }

        // Crear entrega
        $entrega = $this->entregaRepository->create($data);

        // Estados OT
        $ot->load('vehiculos.entregas');
        $faltan = $ot->vehiculos->filter(fn($v) => $v->entregas->isEmpty())->count();

        if ($faltan === 0) {
            $ot->estado = 'entregada';
            $ot->save();
        } else {
            if ($ot->estado !== 'en_transito') {
                $ot->estado = 'en_transito';
                $ot->save();
            }
        }

        // ✅ ENVIAR CORREO
        $to = $data['email_envio'];

        Mail::to($to)
            ->cc(['vhrivas.c@gmail.com', 'victorhugorivaasc@gmail.com'])
            ->send(new EntregaRegistradaMail($entrega->fresh(), $ot));

        return view('entregas.success')->with([
            'success' => 'Entrega registrada correctamente.',
            'entrega' => $entrega,
        ]);
    }

    /**
     * Ver detalle (panel /operacion/entrega/{id} o público /entregas/{id}).
     */
    public function show($id)
    {
        $entrega = $this->entregaRepository->find($id);

        if (empty($entrega)) {
            Flash::error('Entrega no encontrada');

            return redirect()->route('operacion.entrega.index');
        }

        return view('entregas.show', compact('entrega'));
    }

    /**
     * Editar (solo panel interno).
     */
    public function edit($id)
    {
        $entrega = $this->entregaRepository->find($id);

        if (empty($entrega)) {
            Flash::error('Entrega no encontrada');

            return redirect()->route('operacion.entrega.index');
        }

        $ots = Ot::with('cotizacion')->orderBy('id', 'desc')->get();
        $conductores = Conductor::where('activo', true)->orderBy('nombre')->get();

        return view('entregas.edit', compact('entrega', 'ots', 'conductores'));
    }

    /**
     * Actualizar (panel interno).
     */
    public function update($id, Request $request)
    {
        $entrega = $this->entregaRepository->find($id);

        if (empty($entrega)) {
            Flash::error('Entrega no encontrada');
            return redirect()->route('operacion.entrega.index');
        }

        $data = $request->validate([
            'ot_id'             => ['required', 'integer'],
            'nombre_receptor'   => ['required', 'string', 'max:255'],
            'rut_receptor'      => ['nullable', 'string', 'max:50'],
            'telefono_receptor' => ['nullable', 'string', 'max:50'],
            'correo_receptor'   => ['nullable', 'string', 'max:255'],
            'lugar_entrega'     => ['nullable', 'string', 'max:255'],
            'fecha_entrega'     => ['nullable', 'date'],
            'hora_entrega'      => ['nullable', 'string', 'max:20'],
            'numero_guia'       => ['nullable', 'string', 'max:50'],
            'numero_interno'    => ['nullable', 'string', 'max:50'],
            'conforme'          => ['nullable', 'boolean'],
            'observaciones'     => ['nullable', 'string'],

            'foto_1' => ['nullable', 'image', 'max:3072'],
            'foto_2' => ['nullable', 'image', 'max:3072'],
            'foto_3' => ['nullable', 'image', 'max:3072'],
        ]);

        $data['conforme'] = $request->has('conforme') ? (bool) $request->conforme : null;

        $ot = Ot::with('cotizacion')->findOrFail($request->ot_id);
        $data['cliente'] = $ot->cotizacion->cliente ?? 'SIN CLIENTE';

        if ($request->filled('conductor_id')) {
            $data['conductor'] = Conductor::find($request->conductor_id)?->nombre;
        }

        // Mantener fotos antiguas si no se sube una nueva
        foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
            if ($request->hasFile($campo) && $request->file($campo)->isValid()) {
                $data[$campo] = $request->file($campo)->store('entregas', 'public');
            } else {
                $data[$campo] = $entrega->$campo;
            }
        }

        $this->entregaRepository->update($data, $id);

        Flash::success('Entrega actualizada correctamente.');

        return redirect()->route('operacion.entrega.index');
    }

    /**
     * Eliminar (panel interno).
     */
    public function destroy($id)
    {
        $entrega = $this->entregaRepository->find($id);

        if (empty($entrega)) {
            Flash::error('Entrega no encontrada');

            return redirect()->route('operacion.entrega.index');
        }

        $this->entregaRepository->delete($id);

        Flash::success('Entrega eliminada correctamente.');

        return redirect()->route('operacion.entrega.index');
    }
}
