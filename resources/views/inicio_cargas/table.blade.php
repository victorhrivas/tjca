<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="inicio-cargas-table">
            <thead>
            <tr>
                <th>OT</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Tipo Carga</th>
                <th>Fecha Carga</th>
                <th colspan="3">Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inicioCargas as $inicioCarga)
                <tr>
                    <td>{{ optional($inicioCarga->ot)->folio ?? '-' }}</td>
                    <td>{{ $inicioCarga->cliente }}</td>
                    <td>{{ $inicioCarga->vehiculo_label ?? '—' }}</td>
                    <td>{{ $inicioCarga->origen }}</td>
                    <td>{{ $inicioCarga->destino }}</td>
                    <td>{{ $inicioCarga->tipo_carga }}</td>
                    <td>
                        {{ \Illuminate\Support\Carbon::parse($inicioCarga->fecha_carga)->format('d/m/Y') }}
                    </td>
                    <td style="width: 120px">
                        {!! Form::open([
                            'route'  => ['operacion.inicio-carga.destroy', $inicioCarga->id],
                            'method' => 'delete'
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('operacion.inicio-carga.show', $inicioCarga->id) }}"
                            class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type'    => 'submit',
                                'class'   => 'btn btn-danger btn-xs',
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
            @include('adminlte-templates::common.paginate', ['records' => $inicioCargas])
        </div>
    </div>
</div>
