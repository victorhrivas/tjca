<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOtRequest;
use App\Http\Requests\UpdateOtRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OtRepository;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Conductor;
use Carbon\Carbon;
use App\Models\Ot;
use Flash;

class OtController extends AppBaseController
{
    /** @var OtRepository $otRepository*/
    private $otRepository;

    public function __construct(OtRepository $otRepo)
    {
        $this->otRepository = $otRepo;
    }

    /**
     * Display a listing of the Ot.
     */

    public function index(Request $request)
    {
        // Eager load para evitar N+1 en la tabla (vehículos + datos de cotización/solicitud/cliente si los usas)
        $query = Ot::with([
            'vehiculos',
            'cotizacion.solicitud.cliente',
        ]);

        // Texto libre: busca en varios campos (incluye tabla ot_vehiculos)
        if ($request->filled('q')) {
            $q = $request->get('q');

            $query->where(function ($sub) use ($q) {
                $sub->where('cliente', 'like', "%{$q}%")
                    ->orWhere('origen', 'like', "%{$q}%")
                    ->orWhere('destino', 'like', "%{$q}%")
                    ->orWhere('equipo', 'like', "%{$q}%")

                    // Legacy (por compatibilidad)
                    ->orWhere('conductor', 'like', "%{$q}%")
                    ->orWhere('patente_camion', 'like', "%{$q}%")

                    // Nuevo: buscar también en vehículos asociados
                    ->orWhereHas('vehiculos', function ($v) use ($q) {
                        $v->where('conductor', 'like', "%{$q}%")
                        ->orWhere('patente_camion', 'like', "%{$q}%")
                        ->orWhere('patente_remolque', 'like', "%{$q}%");
                    });
            });
        }

        // Cliente (string)
        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->cliente . '%');
        }

        // Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Fecha servicio
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Filtros específicos (opcionales): conductor / patente ahora en tabla nueva también
        if ($request->filled('conductor')) {
            $c = $request->conductor;

            $query->where(function ($sub) use ($c) {
                $sub->where('conductor', 'like', "%{$c}%") // legacy
                    ->orWhereHas('vehiculos', function ($v) use ($c) {
                        $v->where('conductor', 'like', "%{$c}%");
                    });
            });
        }

        if ($request->filled('patente')) {
            $p = $request->patente;

            $query->where(function ($sub) use ($p) {
                $sub->where('patente_camion', 'like', "%{$p}%") // legacy
                    ->orWhereHas('vehiculos', function ($v) use ($p) {
                        $v->where('patente_camion', 'like', "%{$p}%")
                        ->orWhere('patente_remolque', 'like', "%{$p}%");
                    });
            });
        }

        $ots = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->all()); // mantiene filtros en la paginación

        return view('ots.index', compact('ots'));
    }


    /**
     * Show the form for creating a new Ot.
     */
    public function create()
    {
        // Trae solo los conductores activos, ordenados alfabéticamente
        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre'); 
            // clave y valor = nombre, porque tu OT usa un string como conductor

        return view('ots.create', compact('conductores'));
    }

    /**
     * Genera y asigna el folio a una OT recién creada.
     * Formato: AAAAMM/NNN (ej: 202512/001).
     */
    private function asignarFolio(Ot $ot): void
    {
        // Usamos la fecha de servicio si existe; si no, la fecha de creación
        $fechaBase = $ot->fecha ? Carbon::parse($ot->fecha) : $ot->created_at;

        // Ejemplo: 202512
        $periodo = $fechaBase->format('Ym');

        // Cantidad de OTs creadas en ese año/mes (incluida la actual)
        $cantidadMes = Ot::whereYear('created_at', $fechaBase->year)
            ->whereMonth('created_at', $fechaBase->month)
            ->count();

        // Correlativo con 3 dígitos: 001, 002, 003...
        $correlativo = str_pad($cantidadMes, 3, '0', STR_PAD_LEFT);

        $ot->folio = "{$periodo}/{$correlativo}";
        $ot->save();
    }

    public function seguimiento(Request $request)
    {
        $request->validate([
            'numero_ot' => 'required|string',
        ]);

        $folio = trim($request->numero_ot);

        // Cargar OT + relaciones reales
        $ot = Ot::with([
                'cotizacion.solicitud.cliente',
                'inicioCargas',
                'entregas',
            ])
            ->where('folio', $folio)
            ->first();

        if (! $ot) {
            return response()->json([
                'found'   => false,
                'message' => 'No se encontró una OT con ese folio.',
            ]);
        }

        // Cliente asociado
        $clienteNombre = optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social
            ?? $ot->cliente
            ?? '-';

        // ==========================
        // FOTOS DE INICIO DE CARGA
        // ==========================
        $inicioCargaFotos = [];

        // Si quieres tomar SOLO el último inicio de carga:
        $inicio = $ot->inicioCargas->sortByDesc('id')->first();

        if ($inicio) {
            foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
                $ruta = $inicio->{$campo} ?? null;
                if ($ruta) {
                    // Si guardas rutas en disco 'public' tipo "inicio_cargas/xxx.jpg"
                    $inicioCargaFotos[] = Storage::url($ruta);

                    // Si ya son URLs completas, usa en cambio:
                    // $inicioCargaFotos[] = $ruta;
                }
            }
        }

        // ==========================
        // FOTOS DE ENTREGA
        // ==========================
        $entregaFotos = [];

        // Igual: tomamos la última entrega asociada
        $entrega = $ot->entregas->sortByDesc('id')->first();

        if ($entrega) {
            foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
                $ruta = $entrega->{$campo} ?? null;
                if ($ruta) {
                    $entregaFotos[] = Storage::url($ruta);
                }
            }
        }

        return response()->json([
            'found'       => true,
            'folio'       => $ot->folio,
            'estado'      => $ot->estado_label,
            'estado_raw'  => $ot->estado,
            'badge_class' => $ot->estado_badge_class,
            'cliente'     => $clienteNombre,
            'origen'      => $ot->origen,
            'destino'     => $ot->destino,
            'conductor'   => $ot->conductor,
            'fecha'       => $ot->fecha
                                ? \Carbon\Carbon::parse($ot->fecha)->format('d-m-Y')
                                : null,

            // Lo que consume el JS del modal
            'inicio_carga_fotos' => $inicioCargaFotos,
            'entrega_fotos'      => $entregaFotos,
        ]);
    }

    /**
     * Store a newly created Ot in storage.
     */
    public function store(CreateOtRequest $request)
    {
        // 1) Separar vehiculos (NO va a tabla ots)
        $vehiculosInput = $request->input('vehiculos', []);

        // 2) Input limpio para OT (sin vehiculos)
        $input = $request->except('vehiculos');

        // Estado por defecto si no viene
        $input['estado'] = $input['estado'] ?? 'pendiente';

        // Fecha base: la que venga en el formulario o hoy
        $fechaBase = $request->filled('fecha')
            ? Carbon::parse($request->fecha)
            : Carbon::now();

        $input['folio'] = Ot::generarFolioParaFecha($fechaBase);

        // 3) Crear OT
        $ot = $this->otRepository->create($input);

        // 4) Normalizar vehículos (filtrar vacíos)
        $vehiculos = collect($vehiculosInput)
            ->filter(function ($v) {
                return !empty($v['conductor'])
                    || !empty($v['patente_camion'])
                    || !empty($v['patente_remolque']);
            })
            ->values();

        // Si no mandaron ninguno, crea 1 (principal) vacío para consistencia
        if ($vehiculos->isEmpty()) {
            $vehiculos = collect([[
                'conductor' => null,
                'patente_camion' => null,
                'patente_remolque' => null,
            ]]);
        }

        // 5) Guardar vehículos (orden 1..N)
        foreach ($vehiculos as $idx => $v) {
            $ot->vehiculos()->create([
                'conductor'        => $v['conductor'] ?? null,
                'patente_camion'   => $v['patente_camion'] ?? null,
                'patente_remolque' => $v['patente_remolque'] ?? null,
                'orden'            => $idx + 1,
                'rol'              => $idx === 0 ? 'principal' : null,
            ]);
        }

        // 6) (Opcional recomendado) mantener legacy en ots como “cache” del principal
        // Esto ayuda a que reportes/vistas antiguas sigan OK mientras migras.
        $principal = $vehiculos->first();
        $ot->update([
            'conductor' => $principal['conductor'] ?? null,
            'patente_camion' => $principal['patente_camion'] ?? null,
            'patente_remolque' => $principal['patente_remolque'] ?? null,
        ]);

        Flash::success('OT se guardó correctamente.');
        return redirect(route('ots.index'));
    }

    /**
     * Display the specified Ot.
     */
    public function show($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        // Cargar relaciones necesarias para el detalle (incluye fotos)
        $ot->load([
            'cotizacion',     // ya la usas en show_fields
            'inicioCargas',   // para fotos de inicio de carga
            'entregas',       // para fotos de entrega
            'vehiculos',
        ]);

        return view('ots.show')->with('ot', $ot);
    }

    public function pdf($id)
    {
        $ot = Ot::with([
            'cotizacion.cargas',
            'vehiculos',        // <-- nuevo
        ])->findOrFail($id);

        $pdf = Pdf::loadView('ots.pdf', [
            'ot' => $ot,
        ])->setPaper('A4', 'portrait');

        $fileName = 'ot_' . $ot->id . '.pdf';

        return $pdf->stream($fileName);
        // o ->download($fileName)
    }

    /**
     * Show the form for editing the specified Ot.
     */
    public function edit($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('OT no encontrada');
            return redirect(route('ots.index'));
        }

        // Cargar vehículos asociados (para que el fields.blade.php pinte N vehículos)
        $ot->load('vehiculos');

        // Conductores activos para el select
        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre'); // clave y valor = nombre

        return view('ots.edit', compact('ot', 'conductores'));
    }

    /**
     * Update the specified Ot in storage.
     */
    public function update($id, UpdateOtRequest $request)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');
            return redirect(route('ots.index'));
        }

        // 1) Separar vehiculos
        $vehiculosInput = $request->input('vehiculos', []);

        // 2) Actualizar OT sin vehiculos
        $input = $request->except('vehiculos');
        $ot = $this->otRepository->update($input, $id);

        // 3) Normalizar vehículos (filtrar vacíos)
        $vehiculos = collect($vehiculosInput)
            ->filter(function ($v) {
                return !empty($v['conductor'])
                    || !empty($v['patente_camion'])
                    || !empty($v['patente_remolque']);
            })
            ->values();

        if ($vehiculos->isEmpty()) {
            $vehiculos = collect([[
                'conductor' => null,
                'patente_camion' => null,
                'patente_remolque' => null,
            ]]);
        }

        // 4) Estrategia simple: borrar y recrear (consistente y rápido)
        $ot->vehiculos()->delete();

        foreach ($vehiculos as $idx => $v) {
            $ot->vehiculos()->create([
                'conductor'        => $v['conductor'] ?? null,
                'patente_camion'   => $v['patente_camion'] ?? null,
                'patente_remolque' => $v['patente_remolque'] ?? null,
                'orden'            => $idx + 1,
                'rol'              => $idx === 0 ? 'principal' : null,
            ]);
        }

        // 5) Mantener legacy (principal) sincronizado
        $principal = $vehiculos->first();
        $ot->update([
            'conductor' => $principal['conductor'] ?? null,
            'patente_camion' => $principal['patente_camion'] ?? null,
            'patente_remolque' => $principal['patente_remolque'] ?? null,
        ]);

        Flash::success('Ot Actualizada Correctamente.');
        return redirect(route('ots.index'));
    }

    public function updateEstado(Request $request, Ot $ot)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,inicio_carga,en_transito,entregada,con_incidencia',
        ]);

        $ot->estado = $request->estado;
        $ot->save();

        return redirect()
            ->route('ots.index')
            ->with('success', "Estado de la OT #{$ot->id} actualizado a {$ot->estado_label}.");
    }


    /**
     * Remove the specified Ot from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        $this->otRepository->delete($id);

        Flash::success('Ot deleted successfully.');

        return redirect(route('ots.index'));
    }
}
