@extends('layouts.app')

@section('content')
<div class="container container-profile">
    @include('partials.menu')

    <div class="row d-flex-profile">
        <div class="col-md-8">
            <div class="card card-profile h-100">
                <div class="card-header card-header-profile">
                    Información de perfil
                </div>
                <div class="card-body card-body-profile">
                    <p><strong>Nick:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Nombre:</strong> {{ Auth::user()->usuario->nombre ?? 'No disponible' }}</p>
                    <p><strong>Apellidos:</strong> {{ Auth::user()->usuario->apellido ?? 'No disponible' }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Teléfono:</strong> {{ Auth::user()->usuario->telefono ?? 'No disponible' }}</p>
                    <p><strong>Dirección:</strong> {{ Auth::user()->usuario->direccion ?? 'No disponible' }}</p>
                </div>

                <div class="text-center text-center-profile">
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-profile-edit">Editar Perfil</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            <div class="card card-profile h-100 w-100">
                <div class="card-body text-center d-flex justify-content-center align-items-center">
                    @if(Auth::user() && Auth::user()->usuario && Auth::user()->usuario->photo)
                    <img src="{{ asset('storage/' . Auth::user()->usuario->photo) }}" alt="Foto de perfil"
                        class="img-fluid rounded-circle img-profile">
                    @else
                    <p class="no-photo-text">No tienes foto de perfil.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection