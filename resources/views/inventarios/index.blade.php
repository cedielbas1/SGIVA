@extends('layouts.dashboard')

@section('page_title', 'Gestión de Inventarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-box-seam me-2"></i>Gestión de Inventarios</h5>
                    @can('create', App\Models\Inventario::class)
                        <a href="{{ route('inventarios.create') }}" class="btn btn-secondary rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo Inventario
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label" for="inventario-filter-search">Buscar</label>
                            <input id="inventario-filter-search" type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Lote, cultivo, fila...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="inventario-filter-cultivo">Cultivo</label>
                            <select id="inventario-filter-cultivo" name="cultivo_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($cultivos as $cultivo)
                                    <option value="{{ $cultivo->id }}"{{ request('cultivo_id') == $cultivo->id ? ' selected' : '' }}>{{ $cultivo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="inventario-filter-lote">Lote</label>
                            <select id="inventario-filter-lote" name="lote_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($lotes as $lote)
                                    <option value="{{ $lote->id }}"{{ request('lote_id') == $lote->id ? ' selected' : '' }}>{{ $lote->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 d-grid align-self-end">
                            <button type="submit" class="btn btn-secondary">Filtrar</button>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <a href="{{ route('inventarios.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Inventarios encontrados:</strong> {{ $inventarios->total() }}</div>
                            <div class="col-md-4"><strong>Cantidad inicial total:</strong> {{ number_format($totales['cantidad_inicial']) }}</div>
                            <div class="col-md-4"><strong>Cantidad actual total:</strong> {{ number_format($totales['cantidad_actual']) }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <caption class="visually-hidden">Lista de inventarios</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <a href="{{ route('inventarios.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            ID
                                            <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">Lote (Código)</th>
                                    <th scope="col">Cultivo</th>
                                    <th scope="col">
                                        <a href="{{ route('inventarios.index', array_merge(request()->except('page'), ['sort' => 'fila', 'direction' => request('sort') === 'fila' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Fila
                                            <i class="bi {{ request('sort') === 'fila' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('inventarios.index', array_merge(request()->except('page'), ['sort' => 'cantidad_inicial', 'direction' => request('sort') === 'cantidad_inicial' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Cantidad Inicial
                                            <i class="bi {{ request('sort') === 'cantidad_inicial' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('inventarios.index', array_merge(request()->except('page'), ['sort' => 'cantidad_actual', 'direction' => request('sort') === 'cantidad_actual' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Cantidad Actual
                                            <i class="bi {{ request('sort') === 'cantidad_actual' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventarios as $inventario)
                                <tr>
                                    <td>{{ $inventario->id }}</td>
                                    <td><code>{{ $inventario->lote->codigo ?? 'N/A' }}</code></td>
                                    <td><span class="badge bg-success">{{ $inventario->lote->cultivo->nombre ?? 'N/A' }}</span></td>
                                    <td>{{ $inventario->fila }}</td>
                                    <td>{{ $inventario->cantidad_inicial }}</td>
                                    <td><strong>{{ $inventario->cantidad_actual }}</strong></td>
                                    <td class="text-center">
                                        <a href="{{ route('inventarios.show', $inventario) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver inventario {{ $inventario->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        @can('update', $inventario)
                                            <a href="{{ route('inventarios.edit', $inventario) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar inventario {{ $inventario->id }}">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $inventario)
                                            <form action="{{ route('inventarios.destroy', $inventario) }}" method="POST" class="confirm-delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete-button" title="Eliminar" aria-label="Eliminar inventario {{ $inventario->id }}"
                                                    data-confirm-title="Eliminar inventario"
                                                    data-confirm-message="¿Estás seguro de eliminar el inventario #{{ $inventario->id }}? Esta acción no se puede deshacer.">
                                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-box-seam display-4 mb-3"></i>
                                        <br>No hay inventarios registrados aún.
                                        @can('create', App\Models\Inventario::class)
                                            <br><a href="{{ route('inventarios.create') }}" class="btn btn-secondary btn-sm mt-2">Crear primer inventario</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($inventarios->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">Mostrando {{ $inventarios->count() }} de {{ $inventarios->total() }} inventarios</small>
                        {{ $inventarios->links() }}
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
