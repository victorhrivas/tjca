@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-0">Detalle de permiso</h1>
            <small class="text-muted">Información del permiso y roles asociados.</small>
        </div>
        <a href="{{ route('permissions.index') }}" class="btn btn-default">Volver</a>
    </div>

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nombre:</strong> {{ $permission->name }}
            </div>

            <div>
                <strong>Roles asociados:</strong>
                <div class="mt-2 d-flex flex-wrap" style="gap:.5rem;">
                    @forelse($permission->roles as $role)
                        <span class="badge badge-info">{{ ucfirst($role->name) }}</span>
                    @empty
                        <span class="text-muted">Este permiso no está asignado a ningún rol.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection