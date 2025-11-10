<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="puentes-table">
            <thead>
            <tr>
                <th>Ot Id</th>
                <th>Fase</th>
                <th>Motivo</th>
                <th>Detalle</th>
                <th>Notificar Cliente</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($puentes as $puente)
                <tr>
                    <td>{{ $puente->ot_id }}</td>
                    <td>{{ $puente->fase }}</td>
                    <td>{{ $puente->motivo }}</td>
                    <td>{{ $puente->detalle }}</td>
                    <td>{{ $puente->notificar_cliente }}</td>
                    <td>{{ $puente->created_at }}</td>
                    <td>{{ $puente->updated_at }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['puentes.destroy', $puente->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('puentes.show', [$puente->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('puentes.edit', [$puente->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $puentes])
        </div>
    </div>
</div>
