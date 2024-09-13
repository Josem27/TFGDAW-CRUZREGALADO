@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @include('partials.menu')

    <div class="row">
        <div class="col-md-12">
            <div class="card"
                style="background-color: rgba(0, 0, 0, 0.8); color: #fff; padding: 20px; border-radius: 5px;">
                <div class="card-header" style="color: #ffc107;">
                    Gestión de Usuarios
                </div>
                <div class="card-body">
                    <!-- Buscador de usuarios -->
                    <form action="{{ route('gestion.usuarios.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Buscar por nombre o apellido" value="{{ request()->get('search') }}">
                            <button class="btn btn-warning" type="submit">Buscar</button>
                        </div>
                    </form>

                    <!-- Tabla de usuarios -->
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Nick</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Tipo de Usuario</th>
                                <th>Gestión</th> <!-- Nueva columna para la gestión -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->user->name }}</td>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>{{ $usuario->apellido }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->telefono }}</td>
                                    <td>{{ $usuario->direccion }}</td>
                                    <td>{{ $usuario->tipo_usuario }}</td>
                                    <td>
                                        <a href="{{ route('rutinas.index', ['id_usuario' => $usuario->id_usuario]) }}"
                                            class="btn btn-info btn-sm">Rutinas</a>
                                        <a href="{{ route('dietas.index', ['id_usuario' => $usuario->id_usuario]) }}"
                                            class="btn btn-success btn-sm">Dietas</a>
                                        <a href="{{ route('pagos.index', ['id_usuario' => $usuario->id_usuario]) }}"
                                            class="btn btn-primary btn-sm">Pagos</a>
                                        <form
                                            action="{{ route('gestion.usuarios.destroy', ['id_usuario' => $usuario->id_usuario]) }}"
                                            method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar a este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
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
    </div>
</div>
@endsection