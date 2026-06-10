@extends('layouts.dashboard')

@section('page_title', 'Detalles del Lote')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-eye me-2"></i>Detalles del Lote: {{ $lote->codigo }}
                    </h5>
                    <div>
                        @can('update', $lote)
                            <a href="{{ route('lotes.edit', $lote) }}" class="btn btn-warning rounded-pill px-3 me-2">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        @endcan
                        <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">INFORMACIÓN GENERAL</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">ID del Lote</label>
                                            <p class="form-control-plaintext">{{ $lote->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Código</label>
                                            <p class="form-control-plaintext"><code class="fs-5 fw-bold">{{ $lote->codigo }}</code></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cultivo Asociado</label>
                                            <p class="form-control-plaintext">
                                                <span class="badge bg-success fs-6">{{ $lote->cultivo->nombre ?? 'Sin cultivo' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cantidad de Filas</label>
                                            <p class="form-control-plaintext fw-bold">{{ $lote->cantidad_filas }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Estado</label>
                                            <p class="form-control-plaintext">
                                                <span class="badge bg-secondary fs-6">{{ $lote->estado }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha de Registro</label>
                                            <p class="form-control-plaintext">{{ $lote->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-grid-3x3 display-4 text-primary mb-3"></i>
                                    <h5>Estadísticas</h5>
                                    <p class="mb-1"><strong>{{ $lote->inventarios->count() ?? 0 }}</strong> filas con inventario</p>
                                    <small class="text-muted">Información relacionada</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($lote->inventarios) && $lote->inventarios->count() > 0)
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">INVENTARIO POR FILAS</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fila</th>
                                        <th>Cantidad Inicial</th>
                                        <th>Cantidad Actual</th>
                                        <th>Fecha Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lote->inventarios as $inventario)
                                    <tr>
                                        <td><strong>Fila {{ $inventario->fila }}</strong></td>
                                        <td>{{ $inventario->cantidad_inicial }}</td>
                                        <td>{{ $inventario->cantidad_actual }}</td>
                                        <td>{{ $inventario->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="mt-4">
                        <x-alert type="info">
                            Este lote aún no tiene inventario registrado.
                            <a href="#" class="alert-link">Registrar inventario</a>
                        </x-alert>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection