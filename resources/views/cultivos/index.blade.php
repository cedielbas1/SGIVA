@extends('layouts.dashboard')

@section('page_title', 'Gestión de Cultivos')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-sprout me-2"></i>Gestión de Cultivos</h5>
                    @can('create', App\Models\Cultivo::class)
                        <a href="{{ route('cultivos.create') }}" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo Cultivo
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label" for="cultivo-filter-search">Buscar</label>
                            <input id="cultivo-filter-search" type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nombre del cultivo...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="cultivo-filter-estado">Estado</label>
                            <select id="cultivo-filter-estado" name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="activo"{{ request('estado') === 'activo' ? ' selected' : '' }}>Activo</option>
                                <option value="inactivo"{{ request('estado') === 'inactivo' ? ' selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-grid align-self-end">
                            <button type="submit" class="btn btn-success">Filtrar</button>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <a href="{{ route('cultivos.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Total cultivos:</strong> {{ $cultivos->total() }}</div>
                            <div class="col-md-4"><strong>Activos:</strong> {{ $totales['activos'] }}</div>
                            <div class="col-md-4"><strong>Inactivos:</strong> {{ $totales['inactivos'] }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <a href="{{ route('cultivos.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            ID
                                            <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('cultivos.index', array_merge(request()->except('page'), ['sort' => 'nombre', 'direction' => request('sort') === 'nombre' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Nombre del Cultivo
                                            <i class="bi {{ request('sort') === 'nombre' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>Estado</th>
                                    <th>
                                        <a href="{{ route('cultivos.index', array_merge(request()->except('page'), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Fecha Registro
                                            <i class="bi {{ request('sort') === 'created_at' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cultivos as $cultivo)
                                <tr>
                                    <td>{{ $cultivo->id }}</td>
                                    <td class="fw-bold">{{ $cultivo->nombre }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ $cultivo->estado ? 'bg-success' : 'bg-danger' }}">
                                            {{ $cultivo->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ $cultivo->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('cultivos.show', $cultivo) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('update', $cultivo)
                                            <a href="{{ route('cultivos.edit', $cultivo) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $cultivo)
                                            <form action="{{ route('cultivos.destroy', $cultivo) }}" method="POST" class="confirm-delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete-button" title="Eliminar"
                                                    data-confirm-title="Eliminar cultivo"
                                                    data-confirm-message="¿Estás seguro de eliminar el cultivo {{ $cultivo->nombre }}? Esta acción no se puede deshacer.">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No hay cultivos registrados aún.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($cultivos->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">Mostrando {{ $cultivos->count() }} de {{ $cultivos->total() }} cultivos</small>
                        {{ $cultivos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()))
    @include('components.confirm-delete-modal')
@endif
