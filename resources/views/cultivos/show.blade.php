@extends('layouts.dashboard')

@section('page_title', 'Detalles del Cultivo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-eye me-2"></i>Detalles del Cultivo
                    </h5>
                    <div>
                        @can('update', $cultivo)
                            <a href="{{ route('cultivos.edit', $cultivo) }}" class="btn btn-warning rounded-pill px-3 me-2">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                        @endcan
                        <a href="{{ route('cultivos.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
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
                                            <label class="form-label fw-bold">ID del Cultivo</label>
                                            <p class="form-control-plaintext">{{ $cultivo->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nombre</label>
                                            <p class="form-control-plaintext fw-bold text-success">{{ $cultivo->nombre }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Estado</label>
                                            <p class="form-control-plaintext">
                                                <span class="badge rounded-pill {{ $cultivo->estado ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    {{ $cultivo->estado ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha de Registro</label>
                                            <p class="form-control-plaintext">{{ $cultivo->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-sprout display-4 text-success mb-3"></i>
                                    <h5>Estadísticas</h5>
                                    <p class="mb-1"><strong>{{ $cultivo->lotes->count() }}</strong> lotes registrados</p>
                                    <small class="text-muted">Información relacionada</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($cultivo->lotes->count() > 0)
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">LOTES ASOCIADOS</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Cantidad de Filas</th>
                                        <th>Estado</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cultivo->lotes as $lote)
                                    <tr>
                                        <td><code>{{ $lote->codigo }}</code></td>
                                        <td>{{ $lote->cantidad_filas }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $lote->estado }}</span>
                                        </td>
                                        <td>{{ $lote->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="mt-4">
                        <x-alert type="info">
                            Este cultivo aún no tiene lotes registrados.
                            @can('create', App\Models\Lote::class)
                                <a href="{{ route('lotes.create') }}" class="alert-link">Crear primer lote</a>
                            @endcan
                        </x-alert>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection