@extends('layouts.app')

@section('content')
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #ffc107; border: none;">
                    <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                        {{ __('Restablecer Contraseña') }}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert" style="color: #ffc107;">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
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

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" style="background-color: #ffc107; border-color: #ffc107;">
                                        {{ __('Enviar enlace de restablecimiento de contraseña') }}
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
