<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="solicituds-table">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Canal</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Carga</th>
                <th>Valor</th>
                <th>Creada</th>
                <th>Estado</th>
                <th colspan="3">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($solicituds as $solicitud)
                <tr>
                    <!-- Cliente -->
                    <td>{{ optional($solicitud->cliente)->razon_social ?? 'Sin cliente' }}</td>

                    <!-- Canal -->
                    <td>{{ $solicitud->canal }}</td>

                    <!-- Origen / Destino -->
                    <td>{{ $solicitud->origen }}</td>
                    <td>{{ $solicitud->destino }}</td>

                    <!-- Carga -->
                    <td>{{ $solicitud->carga }}</td>

                    <!-- VALOR -->
                    <td>
                        @if(!is_null($solicitud->valor))
                            $ {{ number_format($solicitud->valor, 0, ',', '.') }}
                        @else
                            —
                        @endif
                    </td>

                    <!-- Creada -->
                    <td>{{ $solicitud->created_at ? $solicitud->created_at->format('d/m/y H:i') : '' }}</td>

                    <!-- Estado -->
                    <td>
                        @if($solicitud->estado === 'pendiente')
                            <span class="badge bg-warning text-dark"
                                  style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                Pendiente
                            </span>

                        @elseif($solicitud->estado === 'aprobada')
                            <span class="badge bg-success"
                                  style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                Aprobada
                            </span>

                        @elseif($solicitud->estado === 'fallida')
                            <span class="badge bg-danger"
                                  style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                Fallida
                            </span>
                        @endif
                    </td>

                    <!-- Acciones -->
                    <td style="width: 150px">
                        {{-- Formularios ocultos --}}
                        <form id="aprobar-{{ $solicitud->id }}"
                              action="{{ route('solicituds.aprobar', $solicitud->id) }}"
                              method="POST"
                              style="display:none;">
                            @csrf
                        </form>

                        <form id="eliminar-{{ $solicitud->id }}"
                              action="{{ route('solicituds.destroy', $solicitud->id) }}"
                              method="POST"
                              style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <div class='btn-group'>
                            {{-- Aprobar / Ver cotización --}}
                            @if(!$solicitud->cotizacion)
                                <a href="#"
                                   class="btn btn-success btn-xs"
                                   title="Aprobar"
                                   onclick="event.preventDefault();
                                       if (confirm('¿Aprobar la solicitud y generar una cotización?')) {
                                           document.getElementById('aprobar-{{ $solicitud->id }}').submit();
                                       }">
                                    <i class="fas fa-check"></i>
                                </a>
                            @else
                                <a href="{{ route('cotizacions.show', $solicitud->cotizacion->id) }}"
                                   class="btn btn-success btn-xs"
                                   title="Ver cotización">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            @endif

                            {{-- Fallida --}}
                            @if($solicitud->estado !== 'aprobada')
                                <a href="#"
                                   class="btn btn-warning btn-xs"
                                   title="Marcar como fallida"
                                   onclick="event.preventDefault();
                                       if (confirm('¿Marcar esta solicitud como fallida?')) {
                                           document.getElementById('fallida-{{ $solicitud->id }}').submit();
                                       }">
                                    <i class="fas fa-times"></i>
                                </a>

                                <form id="fallida-{{ $solicitud->id }}"
                                      action="{{ route('solicituds.fallida', $solicitud->id) }}"
                                      method="POST"
                                      style="display:none;">
                                    @csrf
                                </form>
                            @endif

                            {{-- Ver --}}
                            <a href="{{ route('solicituds.show', $solicitud->id) }}"
                               class="btn btn-default btn-xs"
                               title="Ver">
                                <i class="far fa-eye"></i>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('solicituds.edit', $solicitud->id) }}"
                               class="btn btn-default btn-xs"
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- Eliminar --}}
                            <a href="#"
                               class="btn btn-danger btn-xs"
                               title="Eliminar"
                               onclick="event.preventDefault();
                                   if (confirm('¿Eliminar esta solicitud?')) {
                                       document.getElementById('eliminar-{{ $solicitud->id }}').submit();
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
            @include('adminlte-templates::common.paginate', ['records' => $solicituds])
        </div>
    </div>
</div>
