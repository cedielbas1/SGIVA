@extends('layouts.dashboard')

@section('page_title', 'Gestión de Insumos')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-bag me-2"></i>Gestión de Insumos</h5>
                    @can('create', App\Models\Insumo::class)
                        <a href="{{ route('insumos.create') }}" class="btn btn-warning rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo Insumo
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tipo, cultivo...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cultivo</label>
                            <select name="cultivo_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($cultivos as $cultivo)
                                    <option value="{{ $cultivo->id }}"{{ request('cultivo_id') == $cultivo->id ? ' selected' : '' }}>{{ $cultivo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="">Todos</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo }}"{{ request('tipo') === $tipo ? ' selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
                        </div>
                        <div class="col-md-1 d-grid align-self-end">
                            <button type="submit" class="btn btn-warning">Filtrar</button>
                        </div>
                        <div class="col-md-11">
                            <a href="{{ route('insumos.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Insumos encontrados:</strong> {{ $insumos->total() }}</div>
                            <div class="col-md-4"><strong>Total cantidad:</strong> {{ number_format($totales['cantidad']) }}</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <caption class="visually-hidden">Lista de insumos</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <a href="{{ route('insumos.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            ID
                                            <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('insumos.index', array_merge(request()->except('page'), ['sort' => 'tipo', 'direction' => request('sort') === 'tipo' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Tipo
                                            <i class="bi {{ request('sort') === 'tipo' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('insumos.index', array_merge(request()->except('page'), ['sort' => 'cantidad', 'direction' => request('sort') === 'cantidad' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Cantidad
                                            <i class="bi {{ request('sort') === 'cantidad' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">Cultivo Asociado</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($insumos as $insumo)
                                <tr>
                                    <td>{{ $insumo->id }}</td>
                                    <td>{{ $insumo->tipo }}</td>
                                    <td><strong>{{ $insumo->cantidad }}</strong></td>
                                    <td>
                                        @if($insumo->cultivo)
                                            <span class="badge bg-success">{{ $insumo->cultivo->nombre }}</span>
                                        @else
                                            <span class="badge bg-secondary">Sin cultivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $insumo->fecha_ingreso->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('insumos.show', $insumo) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver detalles del insumo {{ $insumo->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        @can('update', $insumo)
                                            <a href="{{ route('insumos.edit', $insumo) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar insumo {{ $insumo->id }}">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $insumo)
                                            <form action="{{ route('insumos.destroy', $insumo) }}" method="POST" class="confirm-delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete-button" title="Eliminar" aria-label="Eliminar insumo {{ $insumo->id }}"
                                                    data-confirm-title="Eliminar insumo"
                                                    data-confirm-message="¿Estás seguro de eliminar el insumo {{ $insumo->nombre }}? Esta acción no se puede deshacer.">
                                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-bag display-4 mb-3"></i>
                                        <br>No hay insumos registrados aún.
                                        @can('create', App\Models\Insumo::class)
                                            <br><a href="{{ route('insumos.create') }}" class="btn btn-warning btn-sm mt-2">Crear primer insumo</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($insumos->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">Mostrando {{ $insumos->count() }} de {{ $insumos->total() }} insumos</small>
                        {{ $insumos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
