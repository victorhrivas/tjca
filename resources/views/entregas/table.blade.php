<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="entregas-table">
            <thead>
            <tr>
                <th>Ot Id</th>
                <th>Nombre Receptor</th>
                <th>Lugar Entrega</th>
                <th>Fecha Entrega</th>
                <th>Conforme</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($entregas as $entrega)
                <tr>
                    <td>{{ $entrega->ot_id }}</td>
                    <td>{{ $entrega->nombre_receptor }}</td>
                    <td>{{ $entrega->lugar_entrega }}</td>
                    <td>{{ $entrega->fecha_entrega }}</td>
                    <td>{{ $entrega->conforme }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['entregas.destroy', $entrega->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('entregas.show', [$entrega->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('entregas.edit', [$entrega->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $entregas])
        </div>
    </div>
</div>
