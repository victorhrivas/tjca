<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="solicituds-table">
            <thead>
            <tr>
                <th>Cliente Id</th>
                <th>Canal</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Carga</th>
                <th>Notas</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($solicituds as $solicitud)
                <tr>
                    <td>{{ $solicitud->cliente_id }}</td>
                    <td>{{ $solicitud->canal }}</td>
                    <td>{{ $solicitud->origen }}</td>
                    <td>{{ $solicitud->destino }}</td>
                    <td>{{ $solicitud->carga }}</td>
                    <td>{{ $solicitud->notas }}</td>
                    <td>{{ $solicitud->created_at ? $solicitud->created_at->format('d/m/y H:i') : '' }}</td>
                    <td>{{ $solicitud->updated_at ? $solicitud->updated_at->format('d/m/y H:i') : '' }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['solicituds.destroy', $solicitud->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('solicituds.show', [$solicitud->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('solicituds.edit', [$solicitud->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $solicituds])
        </div>
    </div>
</div>
