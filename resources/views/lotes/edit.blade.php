@extends('layouts.dashboard')

@section('page_title', 'Editar Lote')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Editar Lote: {{ $lote->codigo }}
                    </h5>
                    <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('lotes.update', $lote) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label fw-bold">Código del Lote <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="codigo"
                                           id="codigo"
                                           class="form-control form-control-lg @error('codigo') is-invalid @enderror"
                                           placeholder="Ej: L001, CAF-01, AGU-2024"
                                           value="{{ old('codigo', $lote->codigo) }}"
                                           required
                                           autofocus>
                                    @error('codigo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Código único que identifica el lote.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cultivo_id" class="form-label fw-bold">Cultivo Asociado <span class="text-danger">*</span></label>
                                    <select name="cultivo_id" id="cultivo_id" class="form-select form-select-lg @error('cultivo_id') is-invalid @enderror" required>
                                        <option value="">Seleccionar cultivo...</option>
                                        @foreach($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $lote->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                                                {{ $cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cultivo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Solo se muestran cultivos activos.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cantidad_filas" class="form-label fw-bold">Cantidad de Filas <span class="text-danger">*</span></label>
                                    <input type="number"
                                           name="cantidad_filas"
                                           id="cantidad_filas"
                                           class="form-control form-control-lg @error('cantidad_filas') is-invalid @enderror"
                                           placeholder="Ej: 10, 25, 50"
                                           value="{{ old('cantidad_filas', $lote->cantidad_filas) }}"
                                           min="1"
                                           required>
                                    @error('cantidad_filas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Número de filas o hileras del lote.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" id="estado" class="form-select form-select-lg @error('estado') is-invalid @enderror" required>
                                        <option value="Disponible" {{ old('estado', $lote->estado) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="En Preparación" {{ old('estado', $lote->estado) == 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                                        <option value="En Producción" {{ old('estado', $lote->estado) == 'En Producción' ? 'selected' : '' }}>En Producción</option>
                                        <option value="Inactivo" {{ old('estado', $lote->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Estado actual del lote.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted">
                                        <strong>Fecha de Creación:</strong> {{ $lote->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Última Actualización:</strong> {{ $lote->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('lotes.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Actualizar Lote
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection