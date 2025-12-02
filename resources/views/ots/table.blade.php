<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="ots-table">
            <thead>
            <tr>
                <th>OT</th>
                <th>Cotización</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Conductor</th>
                <th>Patente Camión</th>
                <th>Patente Remolque</th>
                <th>Estado</th>
                <th>Creada</th>
                <th>Actualizada</th>
                <th colspan="3">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ots as $ot)
                <tr>
                    <td>#{{ $ot->id }}</td>

                    <td>
                        @if($ot->cotizacion)
                            #{{ $ot->cotizacion->id }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        {{ optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social ?? '-' }}
                    </td>

                    <td>{{ optional(optional($ot->cotizacion)->solicitud)->origen ?? '-' }}</td>
                    <td>{{ optional(optional($ot->cotizacion)->solicitud)->destino ?? '-' }}</td>

                    <td>{{ $ot->conductor }}</td>
                    <td>{{ $ot->patente_camion }}</td>
                    <td>{{ $ot->patente_remolque }}</td>

                    <td>{{ $ot->estado }}</td>

                    <td>{{ $ot->created_at ? $ot->created_at->format('d/m/y H:i') : '' }}</td>
                    <td>{{ $ot->updated_at ? $ot->updated_at->format('d/m/y H:i') : '' }}</td>

                    <td style="width: 120px">
                        {!! Form::open(['route' => ['ots.destroy', $ot->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('ots.show', [$ot->id]) }}"
                            class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('ots.edit', [$ot->id]) }}"
                            class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure?')"
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $ots])
        </div>
    </div>
</div>
