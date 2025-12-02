<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="inicio-cargas-table">
            <thead>
            <tr>
                <th>Ot Id</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Tipo Carga</th>
                <th>Fecha Carga</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inicioCargas as $inicioCarga)
                <tr>
                    <td>{{ $inicioCarga->ot_id }}</td>
                    <td>{{ $inicioCarga->cliente }}</td>
                    <td>{{ $inicioCarga->origen }}</td>
                    <td>{{ $inicioCarga->destino }}</td>
                    <td>{{ $inicioCarga->tipo_carga }}</td>
                    <td>{{ $inicioCarga->fecha_carga }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['inicioCargas.destroy', $inicioCarga->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('inicioCargas.show', [$inicioCarga->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('inicioCargas.edit', [$inicioCarga->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $inicioCargas])
        </div>
    </div>
</div>
