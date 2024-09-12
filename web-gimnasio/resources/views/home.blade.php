<!-- resources/views/perfil.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('partials.menu')

        <div class="tab-content" style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
            <div class="tab-pane fade show active">
                <h3>Bienvenido, {{ Auth::user()->name }}</h3>
                <p>Este es tu perfil. Aquí puedes actualizar tu información personal.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-warning">Editar Perfil</a>
            </div>
        </div>
    </div>
@endsection