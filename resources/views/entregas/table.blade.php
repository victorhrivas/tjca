<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="entregas-table">
            <thead>
                <tr>
                    <th>OT</th>
                    <th>Vehículo</th>
                    <th>Nombre Receptor</th>
                    <th>Lugar Entrega</th>
                    <th>Fecha Entrega</th>
                    <th>Conforme</th>
                    <th colspan="3">Acción</th>
                </tr>
            </thead>
            <tbody>
            @foreach($entregas as $entrega)
                <tr>
                    <td>{{ optional($entrega->ot)->folio ?? '-' }}</td>
                    <td>{{ $entrega->vehiculo_label ?? '—' }}</td>
                    <td>{{ $entrega->nombre_receptor }}</td>
                    <td>{{ $entrega->lugar_entrega }}</td>
                    <td>
                        {{ \Illuminate\Support\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}
                    </td>
                    <td>{{ $entrega->conforme ? 'Sí' : 'No' }}</td>
                    <td style="width: 120px">
                        {!! Form::open([
                            'route'  => ['operacion.entrega.destroy', $entrega->id],
                            'method' => 'delete'
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('operacion.entrega.show', $entrega->id) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $entregas])
        </div>
    </div>
</div>
