@extends('layouts.dashboard')

@section('page_title', 'Editar Actividad')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Editar Actividad
                    </h5>
                    <a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body">
                    @can('update', $actividad)
                        <form action="{{ route('actividades.update', $actividad) }}" method="POST" novalidate class="js-validate-form">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_actividad" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                                        <select name="tipo_actividad" id="tipo_actividad" class="form-select form-select-lg @error('tipo_actividad') is-invalid @enderror js-validate" required
                                            aria-required="true"
                                            aria-invalid="@error('tipo_actividad') true @else false @enderror"
                                            @error('tipo_actividad') aria-describedby="tipo_actividad-error" @enderror
                                        >
                                        <option value="Riego" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Riego' ? 'selected' : '' }}>Riego</option>
                                        <option value="Fumigación" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Fumigación' ? 'selected' : '' }}>Fumigación</option>
                                        <option value="Siembra" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Siembra' ? 'selected' : '' }}>Siembra</option>
                                        <option value="Cosecha" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Cosecha' ? 'selected' : '' }}>Cosecha</option>
                                        <option value="Poda" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Poda' ? 'selected' : '' }}>Poda</option>
                                        <option value="Mantenimiento" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                        <option value="Otra" {{ old('tipo_actividad', $actividad->tipo_actividad) == 'Otra' ? 'selected' : '' }}>Otra</option>
                                    </select>
                                    <div id="tipo_actividad-error" class="invalid-feedback js-error" data-for="tipo_actividad" role="alert">{{ $errors->first('tipo_actividad') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lote_id" class="form-label fw-bold">Lote <span class="text-danger">*</span></label>
                                        <select name="lote_id" id="lote_id" class="form-select form-select-lg @error('lote_id') is-invalid @enderror js-validate" required
                                            aria-required="true"
                                            aria-invalid="@error('lote_id') true @else false @enderror"
                                            @error('lote_id') aria-describedby="lote_id-error" @enderror
                                        >
                                        <option value="">Seleccionar lote...</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}" {{ old('lote_id', $actividad->lote_id) == $lote->id ? 'selected' : '' }}>
                                                {{ $lote->codigo }} - {{ $lote->cultivo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="lote_id-error" class="invalid-feedback js-error" data-for="lote_id" role="alert">{{ $errors->first('lote_id') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha" class="form-label fw-bold">Fecha <span class="text-danger">*</span></label>
                                     <input type="date"
                                         name="fecha"
                                         id="fecha"
                                         class="form-control form-control-lg @error('fecha') is-invalid @enderror js-validate"
                                         value="{{ old('fecha', $actividad->fecha->format('Y-m-d')) }}"
                                         required
                                         aria-required="true"
                                         aria-invalid="@error('fecha') true @else false @enderror"
                                         @error('fecha') aria-describedby="fecha-error" @enderror
                                     autofocus>
                                     <div id="fecha-error" class="invalid-feedback js-error" data-for="fecha" role="alert">{{ $errors->first('fecha') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones"
                                              id="observaciones"
                                              class="form-control form-control-lg @error('observaciones') is-invalid @enderror js-validate"
                                              rows="1"
                                              aria-invalid="@error('observaciones') true @else false @enderror"
                                              @error('observaciones') aria-describedby="observaciones-error" @enderror
                                    >{{ old('observaciones', $actividad->observaciones) }}</textarea>
                                    <div id="observaciones-error" class="invalid-feedback js-error" data-for="observaciones" role="alert">{{ $errors->first('observaciones') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $actividad->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Actualizado:</strong> {{ $actividad->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('actividades.index') }}" class="btn btn-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-info rounded-pill px-4">
                                        <i class="bi bi-check-circle me-1"></i>Actualizar Actividad
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                        <x-alert type="warning">
                            No tienes permiso para editar esta actividad. <a href="{{ route('actividades.index') }}" class="alert-link">Volver</a>
                        </x-alert>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
