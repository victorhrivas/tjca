{{-- resources/views/solicituds/show_fields.blade.php --}}

@php
    $clienteNombre = optional($solicitud->cliente)->razon_social ?? ('#'.$solicitud->cliente_id);
@endphp

<div class="col-12 mb-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <div>
            <h5 class="mb-1">Solicitud #{{ $solicitud->id }}</h5>
            <div class="text-muted" style="font-size:.9rem;">
                Creada: {{ optional($solicitud->created_at)->format('d/m/Y H:i') ?? '—' }}
                · Actualizada: {{ optional($solicitud->updated_at)->format('d/m/Y H:i') ?? '—' }}
            </div>
        </div>

        @if(!empty($solicitud->estado))
            <span class="badge badge-pill badge-secondary">
                {{ strtoupper($solicitud->estado) }}
            </span>
        @endif
    </div>
    <hr class="mt-3 mb-0">
</div>

{{-- Datos principales --}}
<div class="col-md-6 mb-3">
    <strong>Cliente</strong>
    <div>{{ $clienteNombre }}</div>
</div>

<div class="col-md-6 mb-3">
    <strong>Canal</strong>
    <div>{{ $solicitud->canal ?? '—' }}</div>
</div>

<div class="col-md-6 mb-3">
    <strong>Solicitante / Vendedor</strong>
    <div>{{ $solicitud->solicitante ?? '—' }}</div>
</div>

<div class="col-md-6 mb-3">
    <strong>Valor estimado (CLP)</strong>
    <div>{{ number_format((int)($solicitud->valor ?? 0), 0, ',', '.') }}</div>
</div>

<div class="col-md-6 mb-3">
    <strong>Origen</strong>
    <div>{{ $solicitud->origen ?? '—' }}</div>
</div>

<div class="col-md-6 mb-3">
    <strong>Destino</strong>
    <div>{{ $solicitud->destino ?? '—' }}</div>
</div>

<div class="col-12 mb-3">
    <strong>Notas</strong>
    <div class="text-muted" style="white-space: pre-wrap;">{{ $solicitud->notas ?? '—' }}</div>
</div>

{{-- Cargas --}}
<div class="col-12 mt-2">
    <h6 class="mb-2">Cargas</h6>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-light">
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Descripción</th>
                    <th style="width:140px;" class="text-right">Cantidad</th>
                    <th style="width:160px;" class="text-right">Precio unitario</th>
                    <th style="width:160px;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cargas = $solicitud->cargas ?? collect();
                    $total  = 0;
                @endphp

                @forelse($cargas as $i => $c)
                    @php
                        $cantidad = (float)($c->cantidad ?? 0);
                        $unit = (int)($c->precio_unitario ?? 0);
                        $sub = (int)($c->subtotal ?? round($cantidad * $unit));
                        $total += $sub;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $c->descripcion ?? '—' }}</td>
                        <td class="text-right">{{ number_format($cantidad, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($unit, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($sub, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Sin cargas registradas.</td>
                    </tr>
                @endforelse
            </tbody>

            @if($cargas->count())
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th class="text-right">{{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    {{-- Si aún usas el campo legacy "carga" --}}
    @if(!empty($solicitud->carga))
        <div class="mt-2 text-muted" style="font-size:.9rem;">
            <strong>Campo legado “carga”:</strong> {{ $solicitud->carga }}
        </div>
    @endif
</div>
