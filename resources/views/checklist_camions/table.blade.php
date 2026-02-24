<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="checklist-camions-table">
            <thead>
            <tr>
                <th>Nombre Conductor</th>
                <th>Patente</th>
                <th>Luces Altas Bajas</th>
                <th>Extintor</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($checklistCamions as $checklistCamion)
                <tr>
                    <td>{{ $checklistCamion->nombre_conductor }}</td>
                    <td>{{ $checklistCamion->patente }}</td>
                    <td>{{ $checklistCamion->luces_altas_bajas }}</td>
                    <td>{{ $checklistCamion->extintor }}</td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['operacion.checklist.destroy', $checklistCamion->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('operacion.checklist.show', $checklistCamion->id) }}"
                            class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('operacion.checklist.edit', $checklistCamion->id) }}"
                            class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('¿Seguro que deseas eliminar este checklist?')"
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
            @include('adminlte-templates::common.paginate', ['records' => $checklistCamions])
        </div>
    </div>
</div>
