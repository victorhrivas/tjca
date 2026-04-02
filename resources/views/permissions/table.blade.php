<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Roles asociados</th>
                <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    <span class="badge badge-info">{{ $permission->roles_count }}</span>
                </td>
                <td>
                    <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    No hay permisos registrados.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($permissions instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="p-3">
        {{ $permissions->links() }}
    </div>
@endif