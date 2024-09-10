@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #ffc107; border: none;">
                <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                    Editar Perfil
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('Nombre Completo') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">{{ __('Dirección') }}</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user->address }}">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo" class="form-label">{{ __('Foto de Perfil (opcional)') }}</label>
                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" style="background-color: #ffc107; border-color: #ffc107;">
                                {{ __('Actualizar Perfil') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection