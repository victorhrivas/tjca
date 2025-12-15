<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInicioCargaRequest;
use App\Http\Requests\UpdateInicioCargaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InicioCargaRepository;
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
        $ots = Ot::with(['cotizacion.solicitud.cliente'])
            ->whereIn('estado', ['pendiente', 'inicio_carga'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($ot) {

                $cliente = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                // Cliente
                if (is_null($ot->cliente)) {
                    $ot->cliente = $cliente?->razon_social;
                }

                // Origen / Destino
                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }

                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }

                // Conductor
                if (is_null($ot->conductor)) {
                    $ot->conductor = optional($ot->cotizacion)->conductor;
                }

                // Datos de contacto
                $ot->contacto          = $cliente?->razon_social;
                $ot->telefono_contacto = $cliente?->telefono ?? '';
                $ot->correo_contacto   = $cliente?->correo   ?? '';

                return $ot;
            });

        $ot = null;
        if ($request->has('ot_id')) {
            $ot = Ot::find($request->get('ot_id'));
        }

        return view('inicio_cargas.create', compact('ots', 'ot'));
    }

    /**
     * Store a newly created InicioCarga in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ot_id'             => ['required', 'integer'],
            'cliente'           => ['required', 'string', 'max:255'],
            'contacto'          => ['nullable', 'string', 'max:255'],
            'telefono_contacto' => ['nullable', 'string', 'max:50'],
            'correo_contacto'   => ['nullable', 'string', 'max:255'],
            'origen'            => ['required', 'string', 'max:255'],
            'destino'           => ['required', 'string', 'max:255'],
            'tipo_carga'        => ['nullable', 'string', 'max:255'],
            'peso_aproximado'   => ['nullable', 'string', 'max:255'],
            'fecha_carga'       => ['nullable', 'date'],
            'hora_presentacion' => ['nullable', 'string', 'max:50'],
            'conductor'         => ['nullable', 'string', 'max:255'],
            'observaciones'     => ['nullable', 'string'],

            // NUEVO: validación de imágenes (máx 4 MB cada una)
            'foto_1'            => ['nullable', 'image', 'max:4096'],
            'foto_2'            => ['nullable', 'image', 'max:4096'],
            'foto_3'            => ['nullable', 'image', 'max:4096'],
        ]);

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

        // Crear inicio de carga
        $inicioCarga = InicioCarga::create($data);

        // Cambiar estado de la OT a "en_transito"
        $ot = Ot::find($data['ot_id']);
        if ($ot) {
            $ot->estado = 'en_transito';
            $ot->save();
        }

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
