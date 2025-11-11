<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="cotizacions-table">
            <thead>
            <tr>
                <th>Solicitud Id</th>
                <th>Estado</th>
                <th>Monto</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cotizacions as $cotizacion)
                <tr>
                    <td>{{ $cotizacion->solicitud_id }}</td>
                    <td>{{ $cotizacion->estado }}</td>
                    <td>{{ $cotizacion->monto }}</td>
                    <td>{{ $cotizacion->created_at ? $cotizacion->created_at->format('d/m/y H:i') : '' }}</td>
                    <td>{{ $cotizacion->updated_at ? $cotizacion->updated_at->format('d/m/y H:i') : '' }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['cotizacions.destroy', $cotizacion->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('cotizacions.show', [$cotizacion->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('cotizacions.edit', [$cotizacion->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $cotizacions])
        </div>
    </div>
</div>
