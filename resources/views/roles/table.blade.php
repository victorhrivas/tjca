<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Permisos</th>
                <th width="180">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ ucfirst($role->name) }}</td>
                <td>
                    <span class="badge badge-info">{{ $role->permissions_count }}</span>
                </td>
                <td>
                    <div class="d-flex" style="gap:.4rem;">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pen"></i>
                        </a>

                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </a>

                        @if($role->name !== 'desarrollador')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este rol?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    No hay roles registrados.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="p-3">
        {{ $roles->links() }}
    </div>
@endif