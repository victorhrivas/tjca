<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="cotizacions-table">
            <thead>
            <tr>
                <th>Cotización</th>
                <th>Solicitud</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Monto</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th colspan="3">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cotizacions as $cotizacion)
                <tr>
                    <td>#{{ $cotizacion->id }}</td>

                    <td>
                        @if($cotizacion->solicitud)
                            #{{ $cotizacion->solicitud->id }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        {{ optional(optional($cotizacion->solicitud)->cliente)->razon_social ?? '-' }}
                    </td>

                    <td>
                        @if($cotizacion->estado === 'enviada')
                            <span class="badge bg-info"
                                  style="font-size:11px;padding:4px 8px;border-radius:6px;">
                                Enviada
                            </span>
                        @elseif($cotizacion->estado === 'aceptada')
                            <span class="badge bg-success"
                                  style="font-size:11px;padding:4px 8px;border-radius:6px;">
                                Aceptada
                            </span>
                        @elseif($cotizacion->estado === 'rechazada')
                            <span class="badge bg-danger"
                                  style="font-size:11px;padding:4px 8px;border-radius:6px;">
                                Rechazada
                            </span>
                        @else
                            <span class="badge bg-secondary"
                                  style="font-size:11px;padding:4px 8px;border-radius:6px;">
                                {{ $cotizacion->estado ?? 'N/A' }}
                            </span>
                        @endif
                    </td>

                    <td>
                        @if(!is_null($cotizacion->monto))
                            {{ number_format($cotizacion->monto, 0, ',', '.') }} CLP
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $cotizacion->created_at ? $cotizacion->created_at->format('d/m/y H:i') : '' }}</td>
                    <td>{{ $cotizacion->updated_at ? $cotizacion->updated_at->format('d/m/y H:i') : '' }}</td>

                    <td style="width: 150px">
                        {{-- Formularios ocultos --}}
                        <form id="generar-ot-{{ $cotizacion->id }}"
                              action="{{ route('cotizacions.generarOt', $cotizacion->id) }}"
                              method="POST"
                              style="display:none;">
                            @csrf
                        </form>

                        <form id="eliminar-cot-{{ $cotizacion->id }}"
                              action="{{ route('cotizacions.destroy', $cotizacion->id) }}"
                              method="POST"
                              style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <div class="btn-group">
                            {{-- Generar OT / Ver OT --}}
                            @if(!$cotizacion->ot)
                                <a href="#"
                                   class="btn btn-success btn-xs"
                                   title="Generar OT"
                                   onclick="event.preventDefault();
                                            if (confirm('¿Generar una OT desde esta cotización?')) {
                                                document.getElementById('generar-ot-{{ $cotizacion->id }}').submit();
                                            }">
                                    <i class="fas fa-truck"></i>
                                </a>
                            @else
                                <a href="{{ route('ots.show', $cotizacion->ot->id) }}"
                                   class="btn btn-success btn-xs"
                                   title="Ver OT">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                            @endif

                            {{-- Ver --}}
                            <a href="{{ route('cotizacions.show', $cotizacion->id) }}"
                               class="btn btn-default btn-xs"
                               title="Ver">
                                <i class="far fa-eye"></i>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('cotizacions.edit', $cotizacion->id) }}"
                               class="btn btn-default btn-xs"
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- Eliminar --}}
                            <a href="#"
                               class="btn btn-danger btn-xs"
                               title="Eliminar"
                               onclick="event.preventDefault();
                                        if (confirm('¿Eliminar esta cotización?')) {
                                            document.getElementById('eliminar-cot-{{ $cotizacion->id }}').submit();
                                        }">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $cotizacions])
        </div>
    </div>
</div>
