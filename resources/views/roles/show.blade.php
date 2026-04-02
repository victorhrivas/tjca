@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Detalle de rol</h1>
            <small class="text-muted">Información del rol y sus permisos asignados.</small>
        </div>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Volver</a>
    </div>

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nombre:</strong> {{ ucfirst($role->name) }}
            </div>

            <div>
                <strong>Permisos:</strong>
                <div class="mt-2 d-flex flex-wrap" style="gap:.5rem;">
                    @forelse($role->permissions as $permission)
                        <span class="badge badge-info">{{ $permission->name }}</span>
                    @empty
                        <span class="text-muted">Este rol no tiene permisos asignados.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection