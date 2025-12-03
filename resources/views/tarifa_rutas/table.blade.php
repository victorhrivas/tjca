<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="tarifa-rutas-table">
            <thead>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Km</th>
                <th>Cama Baja 25 Ton</th>
                <th>Rampla Autodescargable</th>
                <th>Rampla Plana</th>
                <th>Autodescargable 10 Ton</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tarifaRutas as $tarifaRuta)
                <tr>
                    <td>{{ $tarifaRuta->origen }}</td>
                    <td>{{ $tarifaRuta->destino }}</td>
                    <td>{{ $tarifaRuta->km }}</td>
                    <td>{{ $tarifaRuta->cama_baja_25_ton }}</td>
                    <td>{{ $tarifaRuta->rampla_autodescargable }}</td>
                    <td>{{ $tarifaRuta->rampla_plana }}</td>
                    <td>{{ $tarifaRuta->autodescargable_10_ton }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['tarifaRutas.destroy', $tarifaRuta->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('tarifaRutas.show', [$tarifaRuta->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('tarifaRutas.edit', [$tarifaRuta->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $tarifaRutas])
        </div>
    </div>
</div>
