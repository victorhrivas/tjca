@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Informe Diario</h1>
    <form action="{{ route('informe.informe') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha" class="font-weight-medium">Selecciona la fecha:</label>
            <input 
                type="date" 
                name="fecha" 
                id="fecha" 
                class="form-control @error('fecha') is-invalid @enderror" 
                value="{{ old('fecha') }}" 
                required
                style="max-width: 250px;"
            >
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary px-4 mt-3">Generar Informe</button>
        </div>
    </form>
</div>
@endsection
