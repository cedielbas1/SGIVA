@extends('layouts.dashboard')

@section('page_title', 'Nuevo Lote')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Lote
                    </h5>
                    <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('create', App\Models\Lote::class)
                        <form action="{{ route('lotes.store') }}" method="POST" novalidate class="js-validate-form">
                            @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label fw-bold">Código del Lote <span class="text-danger">*</span></label>
                                     <input type="text"
                                         name="codigo"
                                         id="codigo"
                                         class="form-control form-control-lg @error('codigo') is-invalid @enderror js-validate"
                                         placeholder="Ej: L001, CAF-01, AGU-2024"
                                         value="{{ old('codigo') }}"
                                         required
                                         autofocus>
                                     <div class="invalid-feedback js-error" data-for="codigo">{{ $errors->first('codigo') }}</div>
                                    <div class="form-text">Código único que identifica el lote.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cultivo_id" class="form-label fw-bold">Cultivo Asociado <span class="text-danger">*</span></label>
                                    <select name="cultivo_id" id="cultivo_id" class="form-select form-select-lg @error('cultivo_id') is-invalid @enderror js-validate" required>
                                        <option value="">Seleccionar cultivo...</option>
                                        @foreach($cultivos as $cultivo)
                                            <option value="{{ $cultivo->id }}" {{ old('cultivo_id') == $cultivo->id ? 'selected' : '' }}>
                                                {{ $cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback js-error" data-for="cultivo_id">{{ $errors->first('cultivo_id') }}</div>
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
                                         class="form-control form-control-lg @error('cantidad_filas') is-invalid @enderror js-validate"
                                         placeholder="Ej: 10, 25, 50"
                                         value="{{ old('cantidad_filas') }}"
                                         min="1"
                                         required>
                                     <div class="invalid-feedback js-error" data-for="cantidad_filas">{{ $errors->first('cantidad_filas') }}</div>
                                    <div class="form-text">Número de filas o hileras del lote.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label fw-bold">Estado Inicial</label>
                                    <select name="estado" id="estado" class="form-select form-select-lg js-validate">
                                        <option value="Disponible" {{ old('estado', 'Disponible') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="En Preparación" {{ old('estado') == 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                                        <option value="En Producción" {{ old('estado') == 'En Producción' ? 'selected' : '' }}>En Producción</option>
                                        <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    <div class="invalid-feedback js-error" data-for="estado">{{ $errors->first('estado') }}</div>
                                    <div class="form-text">Estado inicial del lote.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('lotes.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Guardar Lote
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para crear lotes. <a href="{{ route('lotes.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection