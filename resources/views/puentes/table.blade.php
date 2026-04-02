<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="puentes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>OT</th>
                    <th>Vehículo afectado</th>
                    <th>Fase</th>
                    <th>Motivo</th>
                    <th>Cambio aplicado</th>
                    <th>Notificar cliente</th>
                    <th>Fecha</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($puentes as $puente)
                @php
                    $ot = $puente->ot;
                    $vehiculo = $puente->otVehiculo;

                    $cambioAplicado = '—';
                    if (!empty($puente->nuevo_conductor)) {
                        $cambioAplicado = 'Nuevo chofer: ' . $puente->nuevo_conductor;
                    } elseif (!empty($puente->nueva_patente_camion)) {
                        $cambioAplicado = 'Nuevo camión: ' . $puente->nueva_patente_camion;
                        if (!empty($puente->nueva_patente_remolque)) {
                            $cambioAplicado .= ' / Remolque: ' . $puente->nueva_patente_remolque;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $puente->id }}</td>

                    <td>
                        @if($ot)
                            <strong>{{ $ot->folio ?: '#'.$ot->id }}</strong>
                            <br>
                            <small class="text-muted">{{ $ot->cliente ?: 'Sin cliente' }}</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        @if($vehiculo)
                            {{ $vehiculo->conductor ?: 'Sin conductor' }}
                            <br>
                            <small class="text-muted">
                                Camión: {{ $vehiculo->patente_camion ?: '—' }}
                                @if($vehiculo->patente_remolque)
                                    · Remolque: {{ $vehiculo->patente_remolque }}
                                @endif
                            </small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>{{ ucfirst(str_replace('_', ' ', $puente->fase)) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $puente->motivo)) }}</td>
                    <td>{{ $cambioAplicado }}</td>

                    <td>
                        @if($puente->notificar_cliente)
                            <span class="badge badge-success">Sí</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>

                    <td>{{ optional($puente->created_at)->format('d-m-Y H:i') }}</td>

                    <td style="width: 120px">
                        {!! Form::open(['route' => ['puentes.destroy', $puente->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('puentes.show', [$puente->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('puentes.edit', [$puente->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('¿Estás seguro de eliminar este puente?')"
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No hay puentes registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $puentes])
        </div>
    </div>
</div>