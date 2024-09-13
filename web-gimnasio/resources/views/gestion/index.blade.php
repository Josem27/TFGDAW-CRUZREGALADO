<!-- resources/views/gestion_usuarios/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @include('partials.menu')

    <div class="card" style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
        <div class="card-header" style="color: #ffc107;">
            Gestión de Usuarios
        </div>
        <div class="card-body">

            <!-- Formulario de búsqueda -->
            <form action="{{ route('gestion.usuarios.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o apellido" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-warning">Buscar</button>
                    </div>
                </div>
            </form>

            <!-- Tabla de usuarios -->
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Nick</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Tipo de Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->tipo_usuario }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $usuarios->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>
@endsection
