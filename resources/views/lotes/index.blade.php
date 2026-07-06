@extends('layouts.dashboard')

@section('page_title', 'Gestión de Lotes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-grid-3x3 me-2"></i>Gestión de Lotes</h5>
                    @can('create', App\Models\Lote::class)
                        <a href="{{ route('lotes.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo Lote
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label" for="lote-filter-search">Buscar</label>
                            <input id="lote-filter-search" type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Código, cultivo...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="lote-filter-cultivo">Cultivo</label>
                            <select id="lote-filter-cultivo" name="cultivo_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($cultivos as $cultivo)
                                    <option value="{{ $cultivo->id }}"{{ request('cultivo_id') == $cultivo->id ? ' selected' : '' }}>{{ $cultivo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="lote-filter-estado">Estado</label>
                            <select id="lote-filter-estado" name="estado" class="form-select">
                                <option value="">Todos</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado }}"{{ request('estado') === $estado ? ' selected' : '' }}>{{ $estado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="lote-filter-fecha-inicio">Desde</label>
                            <input id="lote-filter-fecha-inicio" type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="lote-filter-fecha-fin">Hasta</label>
                            <input id="lote-filter-fecha-fin" type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
                        </div>
                        <div class="col-md-1 d-grid align-self-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                        <div class="col-md-11">
                            <a href="{{ route('lotes.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Total lotes:</strong> {{ $lotes->total() }}</div>
                            <div class="col-md-4"><strong>Filas totales:</strong> {{ number_format($sumFilas) }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <a href="{{ route('lotes.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            ID
                                            <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('lotes.index', array_merge(request()->except('page'), ['sort' => 'codigo', 'direction' => request('sort') === 'codigo' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Código
                                            <i class="bi {{ request('sort') === 'codigo' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('lotes.index', array_merge(request()->except('page'), ['sort' => 'cultivo_id', 'direction' => request('sort') === 'cultivo_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Cultivo
                                            <i class="bi {{ request('sort') === 'cultivo_id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('lotes.index', array_merge(request()->except('page'), ['sort' => 'cantidad_filas', 'direction' => request('sort') === 'cantidad_filas' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Cantidad Filas
                                            <i class="bi {{ request('sort') === 'cantidad_filas' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th>Estado</th>
                                    <th>
                                        <a href="{{ route('lotes.index', array_merge(request()->except('page'), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Fecha Registro
                                            <i class="bi {{ request('sort') === 'created_at' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lotes as $lote)
                                <tr>
                                    <td>{{ $lote->id }}</td>
                                    <td><code class="fw-bold">{{ $lote->codigo }}</code></td>
                                    <td>
                                        <span class="badge bg-success">{{ $lote->cultivo->nombre ?? 'Sin cultivo' }}</span>
                                    </td>
                                    <td>{{ $lote->cantidad_filas }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $lote->estado }}</span>
                                    </td>
                                    <td>{{ $lote->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lotes.show', $lote) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('update', $lote)
                                            <a href="{{ route('lotes.edit', $lote) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $lote)
                                            <form action="{{ route('lotes.destroy', $lote) }}" method="POST" class="confirm-delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete-button" title="Eliminar"
                                                    data-confirm-title="Eliminar lote"
                                                    data-confirm-message="¿Estás seguro de eliminar el lote {{ $lote->codigo }}? Esta acción no se puede deshacer.">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-grid-3x3 display-4 mb-3"></i>
                                        <br>No hay lotes registrados aún.
                                        @can('create', App\Models\Lote::class)
                                            <br><a href="{{ route('lotes.create') }}" class="btn btn-primary btn-sm mt-2">Crear primer lote</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($lotes->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">Mostrando {{ $lotes->count() }} de {{ $lotes->total() }} lotes</small>
                        {{ $lotes->links() }}
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