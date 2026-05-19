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
                    @if($ventas->isEmpty())
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            No hay registros de ventas. <a href="{{ route('ventas.create') }}">Crear primera venta</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <caption class="visually-hidden">Lista de ventas</caption>
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col"><i class="bi bi-hash me-1" aria-hidden="true"></i>ID</th>
                                        <th scope="col"><i class="bi bi-leaf me-1" aria-hidden="true"></i>Cultivo</th>
                                        <th scope="col"><i class="bi bi-diagram-2 me-1" aria-hidden="true"></i>Lote</th>
                                        <th scope="col"><i class="bi bi-box me-1" aria-hidden="true"></i>Cantidad</th>
                                        <th scope="col"><i class="bi bi-currency-dollar me-1" aria-hidden="true"></i>Precio Unit.</th>
                                        <th scope="col"><i class="bi bi-calculator me-1" aria-hidden="true"></i>Total</th>
                                        <th scope="col"><i class="bi bi-calendar me-1" aria-hidden="true"></i>Fecha</th>
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
                                                    <form action="{{ route('ventas.destroy', $venta) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill" title="Eliminar"
                                                            onclick="return confirm('¿Está seguro de eliminar esta venta?')" aria-label="Eliminar venta {{ $venta->id }}">
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
                        <div class="mt-3">
                            <small class="text-muted">
                                <strong>Total de registros:</strong> {{ $ventas->count() }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
