<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Repositories\EntregaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EntregaRegistradaMail;
use Illuminate\Support\Str;
use App\Models\EntregaGuia;
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
        $user = auth()->user();

        $otsQuery = Ot::with([
                'cotizacion.solicitud.cliente',
                'vehiculos' => fn ($q) => $q
                    ->orderBy('orden')
                    ->with(['entregas', 'inicioCargas']),
            ])
            ->whereHas('vehiculos', function ($q) {
                $q->whereHas('inicioCargas')
                ->whereDoesntHave('entregas');
            });

        // Si es chofer, filtrar SOLO las internas por el conductor logueado.
        // Las externas e interno_externo quedan visibles completas.
        if ($user->hasRole('chofer') && trim($user->name) !== 'Externo') {
            $nombreUsuario = trim($user->name);

            $otsQuery->where(function ($q) use ($nombreUsuario) {
                $q->whereIn('traslado', ['externo', 'interno_externo'])
                ->orWhere(function ($sub) use ($nombreUsuario) {
                    $sub->where('traslado', 'interno')
                        ->whereHas('vehiculos', function ($vehiculoQuery) use ($nombreUsuario) {
                            $vehiculoQuery->where('conductor', $nombreUsuario);
                        });
                });
            });
        }

        $ots = $otsQuery
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($ot) use ($user) {
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
                $ot->correo_contacto   = $cliente?->correo ?? '';

                // Solo vehículos que:
                // 1) ya tienen inicio de carga
                // 2) aún no tienen entrega
                $vehiculos = $ot->vehiculos
                    ->filter(function ($vehiculo) {
                        return $vehiculo->inicioCargas->isNotEmpty()
                            && $vehiculo->entregas->isEmpty();
                    })
                    ->values();

                // Si es chofer y la OT es interna, mostrar solo sus vehículos
                if (
                    $user->hasRole('chofer') &&
                    trim($user->name) !== 'Externo' &&
                    $ot->traslado === 'interno'
                ) {
                    $nombreUsuario = trim($user->name);

                    $vehiculos = $vehiculos
                        ->filter(function ($vehiculo) use ($nombreUsuario) {
                            return trim((string) $vehiculo->conductor) === $nombreUsuario;
                        })
                        ->values();
                }

                $ot->setRelation('vehiculos', $vehiculos);

                return $ot;
            })
            ->filter(function ($ot) {
                // Si después del filtro no quedaron vehículos visibles, no mostrar OT
                return $ot->vehiculos->isNotEmpty();
            })
            ->values();

        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('entregas.create', compact('ots', 'conductores'));
    }

    /**
     * Guardar entrega (se usa tanto en público como en panel).
     */
    // EntregaController@store (reemplaza la parte de "email_envio" y el envío)

    public function store(Request $request)
    {
        $data = $request->validate([
            'ot_id'          => ['required', 'integer', 'exists:ots,id'],
            'ot_vehiculo_id' => ['required', 'integer', 'exists:ot_vehiculos,id'],

            'conductor_id'   => ['required', 'integer', 'exists:conductors,id'],

            'nombre_receptor'   => ['required', 'string', 'max:255'],
            'rut_receptor'      => ['nullable', 'string', 'max:50'],
            'telefono_receptor' => ['nullable', 'string', 'max:50'],
            'correo_receptor'   => ['nullable', 'string', 'max:255'],

            // en tu form está required, así que aquí también
            'lugar_entrega'  => ['required', 'string', 'max:255'],
            'fecha_entrega'  => ['required', 'date'],
            'hora_entrega'   => ['nullable', 'string', 'max:20'],

            'numero_guia'    => ['nullable', 'string', 'max:50'],
            'numero_interno' => ['nullable', 'string', 'max:50'],
            'conforme'       => ['nullable', 'boolean'],
            'observaciones'  => ['nullable', 'string'],

            'foto_1' => ['nullable', 'image', 'max:10240'],
            'foto_2' => ['nullable', 'image', 'max:10240'],
            'foto_3' => ['nullable', 'image', 'max:10240'],

            'guias_despacho'   => ['required', 'array', 'min:1'],
            'guias_despacho.*' => ['file', 'image', 'max:5120'],
        ]);

        // Radio conformidad: si viene, lo dejamos en bool; si no viene, null
        $data['conforme'] = $request->has('conforme') ? (bool) $request->input('conforme') : null;

        // OT con relaciones necesarias (correo + vehículos + entregas)
        $ot = Ot::with([
            'vehiculos.entregas',
            'cotizacion.clienteEjecutivo',
            'cotizacion.solicitud.cliente',
        ])->findOrFail($data['ot_id']);

        // Validación de negocio: que el vehículo pertenezca a la OT
        if (!$ot->vehiculos->contains('id', (int) $data['ot_vehiculo_id'])) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'El vehículo seleccionado no pertenece a la OT.',
            ]);
        }

        $user = auth()->user();

        if ($user && $user->hasRole('chofer')) {
            $vehiculo = $ot->vehiculos->firstWhere('id', (int) $data['ot_vehiculo_id']);

            if ($vehiculo && $ot->traslado === 'interno') {
                if (trim((string) $vehiculo->conductor) !== trim((string) $user->name)) {
                    return back()->withInput()->withErrors([
                        'ot_vehiculo_id' => 'No puedes registrar la entrega de un vehículo interno asignado a otro chofer.',
                    ]);
                }
            }
        }

        // Evitar duplicado (además del unique en DB)
        $yaExiste = Entrega::where('ot_id', $data['ot_id'])
            ->where('ot_vehiculo_id', $data['ot_vehiculo_id'])
            ->exists();

        if ($yaExiste) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Este vehículo ya registró entrega para esta OT.',
            ]);
        }

        // Datos derivados
        $data['cliente'] = optional($ot->cotizacion)->cliente ?? 'SIN CLIENTE';

        // Guardar nombre de conductor (columna entregas.conductor)
        $data['conductor'] = Conductor::find($data['conductor_id'])?->nombre ?? '';

        // Fotos opcionales (entrega)
        foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
            if ($request->hasFile($campo) && $request->file($campo)->isValid()) {
                $data[$campo] = $request->file($campo)->store('entregas', 'public');
            }
        }

        // ✅ Resolver correo destino desde la cotización (MISMA lógica que InicioCarga)
        $emailCliente =
            optional(optional($ot->cotizacion)->clienteEjecutivo)->correo
            ?: optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->correo;

        if (!$emailCliente || !filter_var($emailCliente, FILTER_VALIDATE_EMAIL)) {
            return back()->withInput()->withErrors([
                'ot_id' => 'No hay correo válido configurado en la cotización/cliente para esta OT.',
            ]);
        }

        // Crear entrega (sin guías todavía)
        $entrega = $this->entregaRepository->create($data);

        // Guardar N guías
        $files = $request->file('guias_despacho', []);
        $orden = 1;

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) continue;

            $name = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('entregas/guias', $name, 'public');

            EntregaGuia::create([
                'entrega_id' => $entrega->id,
                'archivo'    => $path,
                'orden'      => $orden++,
            ]);
        }

        // Recalcular estado OT según entregas por vehículo
        $ot->refresh()->load('vehiculos.entregas');
        $faltan = $ot->vehiculos->filter(fn($v) => $v->entregas->isEmpty())->count();

        if ($faltan === 0) {
            $ot->estado = 'entregada';
        } else {
            if ($ot->estado !== 'en_transito') {
                $ot->estado = 'en_transito';
            }
        }
        $ot->save();

        // Enviar correo al mismo destinatario que InicioCarga
        Mail::to($emailCliente)
            ->cc(['jgcontador@tjca.cl', 'fhenott@tjca.cl', 'vhrivas.c@gmail.com'])
            ->send(new EntregaRegistradaMail($entrega->fresh(['guias']), $ot));

        return view('entregas.success', [
            'success' => 'Entrega registrada correctamente.',
            'entrega' => $entrega,
        ]);
    }

    /**
     * Ver detalle (panel /operacion/entrega/{id} o público /entregas/{id}).
     */
    public function show($id)
    {
        // Traer la entrega y cargar relaciones necesarias (incluye guías)
        $entrega = $this->entregaRepository->find($id);

        if (empty($entrega)) {
            Flash::error('Entrega no encontrada');
            return redirect()->route('operacion.entrega.index');
        }

        // Cargar relaciones (evita N+1 y permite mostrar múltiples guías)
        $entrega->load([
            'ot',
            'guias',
            // opcional si lo ocupas en la vista o mail:
            // 'otVehiculo',
        ]);

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
