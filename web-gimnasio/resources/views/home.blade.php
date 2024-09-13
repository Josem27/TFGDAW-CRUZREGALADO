@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @include('partials.menu')

    <div class="row d-flex align-items-stretch"> <!-- Usamos Flexbox -->
        <div class="col-md-8">
            <div class="card h-100" style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
                <div class="card-header" style="color: #ffc107;">
                    Información de perfil
                </div>
                <div class="card-body" style="font-size: 1.2em;"> <!-- Aumenta el tamaño del texto -->
                    <p><strong>Nick:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Nombre:</strong> {{ Auth::user()->usuario->nombre ?? 'No disponible' }}</p>
                    <p><strong>Apellidos:</strong> {{ Auth::user()->usuario->apellido ?? 'No disponible' }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Teléfono:</strong> {{ Auth::user()->usuario->telefono ?? 'No disponible' }}</p>
                    <p><strong>Dirección:</strong> {{ Auth::user()->usuario->direccion ?? 'No disponible' }}</p>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Editar Perfil</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex">
            <div class="card h-100 w-100"
                style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
                <div class="card-body text-center d-flex justify-content-center align-items-center">
                    @if(Auth::user()->usuario->photo)
                        <img src="{{ asset('storage/' . Auth::user()->usuario->photo) }}" alt="Foto de perfil"
                            class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
                    @else
                        <p>No tienes foto de perfil.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection