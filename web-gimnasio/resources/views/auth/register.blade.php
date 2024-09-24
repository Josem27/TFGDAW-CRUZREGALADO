@extends('layouts.app')

@section('content')
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #ffc107; border: none;">
                    <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                        Registrarse
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="name" class="col-form-label" style="color: #ffc107;">{{ __('Nickname') }}</label>

                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="background-color: #333; color: #fff; border: none;">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="email" class="col-form-label" style="color: #ffc107;">{{ __('Correo Electrónico') }}</label>

                                <div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="background-color: #333; color: #fff; border: none;">

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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="background-color: #333; color: #fff; border: none;">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert" style="color: #ff6b6b;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="password-confirm" class="col-form-label" style="color: #ffc107;">{{ __('Confirmar Contraseña') }}</label>

                                <div>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="background-color: #333; color: #fff; border: none;">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" style="background-color: #ffc107; border-color: #ffc107;">
                                        {{ __('Registrarse') }}
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row mb-3 mt-3">
                                <div class="col-md-12 text-center">
                                    <a class="btn btn-link" href="{{ route('login') }}" style="color: #ffc107;">
                                        {{ __('¿Ya tienes una cuenta? Inicia Sesión') }}
                                    </a>
                                    <a class="btn btn-link" href="{{ url('/') }}" style="color: #ffc107;">
                                        {{ __('Volver a la página principal') }}
                                    </a>
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
