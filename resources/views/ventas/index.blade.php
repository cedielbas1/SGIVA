@extends('layouts.dashboard')

@section('page_title', 'Gestión de Ventas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-cash-coin me-2"></i>Registro de Ventas
                    </h5>
                    @auth
                        @can('create', App\Models\Venta::class)
                            <a href="{{ route('ventas.create') }}" class="btn btn-success rounded-pill px-4">
                                <i class="bi bi-plus-circle me-1"></i>Nueva Venta
                            </a>
                        @endcan
                    @endauth
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cultivo, lote...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cultivo</label>
                            <select name="cultivo_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($cultivos as $cultivo)
                                    <option value="{{ $cultivo->id }}"{{ request('cultivo_id') == $cultivo->id ? ' selected' : '' }}>{{ $cultivo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Lote</label>
                            <select name="lote_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($lotes as $lote)
                                    <option value="{{ $lote->id }}"{{ request('lote_id') == $lote->id ? ' selected' : '' }}>{{ $lote->codigo }} - {{ $lote->cultivo->nombre ?? 'Sin cultivo' }}</option>
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
                        <div class="col-md-1 d-grid">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('ventas.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Ventas encontradas:</strong> {{ $ventas->total() }}</div>
                            <div class="col-md-4"><strong>Total unidades:</strong> {{ number_format($totales['cantidad_vendida']) }}</div>
                            <div class="col-md-4"><strong>Ingresos totales:</strong> ${{ number_format($totales['total'], 2) }}</div>
                        </div>
                    </div>

                    @if($ventas->isEmpty())
                        <x-alert type="info">
                            No hay registros de ventas.
                            @can('create', App\Models\Venta::class)
                                <a href="{{ route('ventas.create') }}" class="alert-link">Crear primera venta</a>
                            @endcan
                        </x-alert>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <caption class="visually-hidden">Lista de ventas</caption>
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-hash me-1" aria-hidden="true"></i>ID
                                                <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'cultivo_id', 'direction' => request('sort') === 'cultivo_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-leaf me-1" aria-hidden="true"></i>Cultivo
                                                <i class="bi {{ request('sort') === 'cultivo_id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'lote_id', 'direction' => request('sort') === 'lote_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-diagram-2 me-1" aria-hidden="true"></i>Lote
                                                <i class="bi {{ request('sort') === 'lote_id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'cantidad_vendida', 'direction' => request('sort') === 'cantidad_vendida' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-box me-1" aria-hidden="true"></i>Cantidad
                                                <i class="bi {{ request('sort') === 'cantidad_vendida' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'precio_unitario', 'direction' => request('sort') === 'precio_unitario' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-currency-dollar me-1" aria-hidden="true"></i>Precio Unit.
                                                <i class="bi {{ request('sort') === 'precio_unitario' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'total', 'direction' => request('sort') === 'total' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-calculator me-1" aria-hidden="true"></i>Total
                                                <i class="bi {{ request('sort') === 'total' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">
                                            <a href="{{ route('ventas.index', array_merge(request()->except('page'), ['sort' => 'fecha_venta', 'direction' => request('sort') === 'fecha_venta' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                                <i class="bi bi-calendar me-1" aria-hidden="true"></i>Fecha
                                                <i class="bi {{ request('sort') === 'fecha_venta' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                            </a>
                                        </th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                        <tr>
                                            <td><strong>{{ $venta->id }}</strong></td>
                                            <td>{{ $venta->cultivo->nombre }}</td>
                                            <td>{{ $venta->lote->codigo }}</td>
                                            <td><span class="badge bg-primary">{{ $venta->cantidad_vendida }}</span></td>
                                            <td>${{ number_format($venta->precio_unitario, 2) }}</td>
                                            <td><strong class="text-success">${{ number_format($venta->total, 2) }}</strong></td>
                                            <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-info rounded-pill" title="Ver" aria-label="Ver venta {{ $venta->id }}">
                                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                                </a>
                                                @can('update', $venta)
                                                    <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-sm btn-warning rounded-pill" title="Editar" aria-label="Editar venta {{ $venta->id }}">
                                                        <i class="bi bi-pencil" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                                @can('delete', $venta)
                                                    <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="confirm-delete-form" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill confirm-delete-button" title="Eliminar"
                                                            aria-label="Eliminar venta {{ $venta->id }}"
                                                            data-confirm-title="Eliminar venta"
                                                            data-confirm-message="¿Estás seguro de eliminar la venta #{{ $venta->id }}? Esta acción no se puede deshacer.">
                                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <strong>Mostrando:</strong> {{ $ventas->count() }} / {{ $ventas->total() }} registros
                            </small>
                            {{ $ventas->links() }}
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
