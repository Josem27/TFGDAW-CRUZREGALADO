@extends('layouts.app')

@section('content')
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #ffc107; border: none;">
                    <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                        Inicia sesión
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="email" class="col-form-label" style="color: #ffc107;">{{ __('Correo Electrónico') }}</label>

                                <div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="background-color: #333; color: #fff; border: none;">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password" class="col-form-label" style="color: #ffc107;">{{ __('Contraseña') }}</label>

                                <div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="background-color: #333; color: #fff; border: none;">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-md-12 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember" style="color: #ffc107;">
                                            {{ __('Recuérdame') }}
                                        </label>
                                    </div>

                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #ffc107;">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" style="background-color: #ffc107; border-color: #ffc107;">
                                        {{ __('Iniciar Sesión') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
