@extends('layouts.dashboard')

@section('page_title', 'Mi cuenta')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Perfil de usuario</h5>
                    <span class="text-muted">Actualiza tus datos</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('account.update') }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label for="name" class="form-label">Nombre completo</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">Rol: <strong>{{ ucfirst($user->role) }}</strong></small>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Cambiar contraseña</h5>
                    <span class="text-muted">Protege tu cuenta</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('account.password') }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <input id="current_password" type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-warning">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Información</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p class="mb-2"><strong>Correo:</strong> {{ $user->email }}</p>
                    <p class="mb-0"><strong>Registrado:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
