<head>
<link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>
@extends('layouts.app')

@section('content')
<div class="container container-edit-profile">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-edit-profile">
                <div class="card-header card-header-edit-profile">
                    Editar perfil
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group form-group-edit">
                            <label for="nick" class="form-label">Nick</label>
                            <input id="nick" type="text" class="form-control @error('nick') is-invalid @enderror"
                                   name="nick" value="{{ old('nick', $user->name) }}" required>
                            @error('nick')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   name="nombre" value="{{ old('nombre', $user->usuario->nombre ?? '') }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror"
                                   name="apellido" value="{{ old('apellido', $user->usuario->apellido ?? '') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror"
                                   name="telefono" value="{{ old('telefono', $user->usuario->telefono ?? '') }}" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror"
                                   name="direccion" value="{{ old('direccion', $user->usuario->direccion ?? '') }}" required>
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-edit">
                            <label for="photo" class="form-label">Foto de Perfil</label>
                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror"
                                   name="photo">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning btn-edit-profile">Guardar Cambios</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-back-profile">Regresar</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex d-flex-edit-profile">
            <div class="card h-100 w-100 card-edit-profile">
                <div class="card-body text-center d-flex justify-content-center align-items-center">
                    @if(Auth::user()->usuario->photo)
                        <img src="{{ asset('storage/' . Auth::user()->usuario->photo) }}" alt="Foto de perfil"
                             class="img-fluid rounded-circle img-profile-edit">
                    @else
                        <p class="no-photo-text-edit">No tienes foto de perfil.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection