@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" novalidate class="js-validate-form">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror js-validate" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Tu nombre completo">
                                <div class="invalid-feedback js-error" data-for="name"><strong>{{ $errors->first('name') }}</strong></div>
                                <div class="form-text">Usa tu nombre real para identificación.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror js-validate" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="correo@dominio.com">
                                <div class="invalid-feedback js-error" data-for="email"><strong>{{ $errors->first('email') }}</strong></div>
                                <div class="form-text">Se usará para iniciar sesión y notificaciones.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror js-validate" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                                <div class="invalid-feedback js-error" data-for="password"><strong>{{ $errors->first('password') }}</strong></div>
                                <div class="form-text">Usa una contraseña segura y única.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control js-validate" name="password_confirmation" required autocomplete="new-password" placeholder="Repite la contraseña">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarse') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
