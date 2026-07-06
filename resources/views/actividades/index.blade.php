@extends('layouts.dashboard')

@section('page_title', 'Gestión de Actividades')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info"><i class="bi bi-clipboard-check me-2"></i>Gestión de Actividades</h5>
                    @can('create', App\Models\Actividad::class)
                        <a href="{{ route('actividades.create') }}" class="btn btn-info rounded-pill px-4">
                            <i class="bi bi-plus-lg me-1"></i> Nueva Actividad
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Actividad, lote, usuario...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipo</label>
                            <select name="tipo_actividad" class="form-select">
                                <option value="">Todos</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo }}"{{ request('tipo_actividad') === $tipo ? ' selected' : '' }}>{{ $tipo }}</option>
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
                            <label class="form-label">Usuario</label>
                            <select name="usuario_id" class="form-select">
                                <option value="">Todos</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}"{{ request('usuario_id') == $usuario->id ? ' selected' : '' }}>{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
                        </div>
                        <div class="col-md-1 d-grid align-self-end">
                            <button type="submit" class="btn btn-info">Filtrar</button>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('actividades.index') }}" class="text-decoration-none">Limpiar filtros</a>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row gy-2">
                            <div class="col-md-4"><strong>Actividades encontradas:</strong> {{ $actividades->total() }}</div>
                            <div class="col-md-8">
                                @if($totalesPorTipo->isNotEmpty())
                                    <strong>Subtotal por tipo:</strong>
                                    @foreach($totalesPorTipo as $item)
                                        <span class="badge bg-secondary me-1">{{ $item->tipo_actividad }}: {{ $item->total }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <caption class="visually-hidden">Lista de actividades</caption>
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <a href="{{ route('actividades.index', array_merge(request()->except('page'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            ID
                                            <i class="bi {{ request('sort') === 'id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('actividades.index', array_merge(request()->except('page'), ['sort' => 'tipo_actividad', 'direction' => request('sort') === 'tipo_actividad' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Tipo de Actividad
                                            <i class="bi {{ request('sort') === 'tipo_actividad' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('actividades.index', array_merge(request()->except('page'), ['sort' => 'lote_id', 'direction' => request('sort') === 'lote_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Lote
                                            <i class="bi {{ request('sort') === 'lote_id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('actividades.index', array_merge(request()->except('page'), ['sort' => 'usuario_id', 'direction' => request('sort') === 'usuario_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Usuario
                                            <i class="bi {{ request('sort') === 'usuario_id' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{ route('actividades.index', array_merge(request()->except('page'), ['sort' => 'fecha', 'direction' => request('sort') === 'fecha' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="link-dark text-decoration-none">
                                            Fecha
                                            <i class="bi {{ request('sort') === 'fecha' ? (request('direction') === 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short') : 'bi-arrow-down-up' }} ms-1"></i>
                                        </a>
                                    </th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($actividades as $actividad)
                                <tr>
                                    <td>{{ $actividad->id }}</td>
                                    <td><span class="badge bg-info">{{ $actividad->tipo_actividad }}</span></td>
                                    <td><code>{{ $actividad->lote->codigo ?? 'N/A' }}</code></td>
                                    <td>{{ $actividad->usuario->name ?? 'N/A' }}</td>
                                    <td>{{ $actividad->fecha->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('actividades.show', $actividad) }}" class="btn btn-sm btn-outline-info me-1" title="Ver detalles" aria-label="Ver actividad {{ $actividad->id }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        @can('update', $actividad)
                                            <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar" aria-label="Editar actividad {{ $actividad->id }}">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $actividad)
                                            <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" class="confirm-delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete-button" title="Eliminar" aria-label="Eliminar actividad {{ $actividad->id }}"
                                                    data-confirm-title="Eliminar actividad"
                                                    data-confirm-message="¿Estás seguro de eliminar la actividad #{{ $actividad->id }}? Esta acción no se puede deshacer.">
                                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-clipboard-check display-4 mb-3"></i>
                                        <br>No hay actividades registradas aún.
                                        @can('create', App\Models\Actividad::class)
                                            <br><a href="{{ route('actividades.create') }}" class="btn btn-info btn-sm mt-2">Crear primera actividad</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($actividades->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">Mostrando {{ $actividades->count() }} de {{ $actividades->total() }} actividades</small>
                        {{ $actividades->links() }}
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
