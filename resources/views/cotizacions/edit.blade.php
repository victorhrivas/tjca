@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        Editar Cotizacion
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($cotizacion, ['route' => ['cotizacions.update', $cotizacion->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('cotizacions.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('cotizacions.index') }}" class="btn btn-default"> Cancelar </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ENDPOINT = '{{ route('solicituds.select') }}';

  new TomSelect('#solicitud_id', {
    valueField: 'id',
    labelField: 'text',
    searchField: ['text'],
    maxOptions: 200,
    create: false,
    placeholder: 'Buscar por ID, cliente o fecha (dd/mm/aaaa)',
    shouldLoad: function(query){ return true; }, // permite cargar con query vacío
    load: function(query, callback) {
      const url = ENDPOINT + '?q=' + encodeURIComponent(query || '');
      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.ok ? r.json() : [])
        .then(data => callback(data))
        .catch(() => callback());
    },
    // precarga últimos registros al abrir
    onInitialize: function() {
      const self = this;
      setTimeout(() => self.load(''), 0);
    }
  });
});
</script>
@endpush


@endsection


