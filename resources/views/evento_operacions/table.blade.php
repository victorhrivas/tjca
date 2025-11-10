<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="evento-operacions-table">
            <thead>
            <tr>
                <th>Ot Id</th>
                <th>Tipo</th>
                <th>Observaciones</th>
                <th>Fotos</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($eventoOperacions as $eventoOperacion)
                <tr>
                    <td>{{ $eventoOperacion->ot_id }}</td>
                    <td>{{ $eventoOperacion->tipo }}</td>
                    <td>{{ $eventoOperacion->observaciones }}</td>
                    <td>{{ $eventoOperacion->fotos }}</td>
                    <td>{{ $eventoOperacion->created_at }}</td>
                    <td>{{ $eventoOperacion->updated_at }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['eventoOperacions.destroy', $eventoOperacion->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('eventoOperacions.show', [$eventoOperacion->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('eventoOperacions.edit', [$eventoOperacion->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $eventoOperacions])
        </div>
    </div>
</div>
