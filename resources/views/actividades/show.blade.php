@extends('layouts.dashboard')

@section('page_title', 'Detalles de la Actividad')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-eye me-2"></i>Detalles de la Actividad
                    </h5>
                    <div>
                        <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-warning rounded-pill px-3 me-2">
                            <i class="bi bi-pencil me-1"></i>Editar
                        </a>
                        <a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
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
                                            <label class="form-label fw-bold">ID</label>
                                            <p class="form-control-plaintext">{{ $actividad->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tipo</label>
                                            <p class="form-control-plaintext"><span class="badge bg-info">{{ $actividad->tipo_actividad }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Lote</label>
                                            <p class="form-control-plaintext"><code>{{ $actividad->lote->codigo }}</code></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Usuario</label>
                                            <p class="form-control-plaintext">{{ $actividad->usuario->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha</label>
                                            <p class="form-control-plaintext">{{ $actividad->fecha->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Cultivo</label>
                                            <p class="form-control-plaintext"><span class="badge bg-success">{{ $actividad->lote->cultivo->nombre }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                @if($actividad->observaciones)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Observaciones</label>
                                            <p class="form-control-plaintext">{{ $actividad->observaciones }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-clipboard-check display-4 text-info mb-3"></i>
                                    <h5>Información</h5>
                                    <p class="mb-1"><strong>Registrado por:</strong><br>{{ $actividad->usuario->name }}</p>
                                    <small class="text-muted">Actividad sistema</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted mb-3">INFORMACIÓN DE SISTEMA</h6>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong>Creado:</strong> {{ $actividad->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Actualizado:</strong> {{ $actividad->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
