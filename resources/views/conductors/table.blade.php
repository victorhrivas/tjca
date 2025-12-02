<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="conductors-table">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Licencia</th>
                <th>Activo</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($conductors as $conductor)
                <tr>
                    <td>{{ $conductor->nombre }}</td>
                    <td>{{ $conductor->rut }}</td>
                    <td>{{ $conductor->telefono }}</td>
                    <td>{{ $conductor->correo }}</td>
                    <td>{{ $conductor->licencia }}</td>
                    <td>{{ $conductor->activo }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['conductors.destroy', $conductor->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('conductors.show', [$conductor->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('conductors.edit', [$conductor->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $conductors])
        </div>
    </div>
</div>
