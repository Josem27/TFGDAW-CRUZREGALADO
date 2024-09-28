<head>
<link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @include('partials.menu')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-gestion-usuarios">
                <div class="card-header header-gestion-usuarios">
                    Gestión de Usuarios
                </div>
                <div class="card-body">
                    <form action="{{ route('gestion.usuarios.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Buscar por nombre o apellido" value="{{ request()->get('search') }}">
                            <button class="btn btn-warning" type="submit">Buscar</button>
                        </div>
                    </form>

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
                                <th>Gestión</th>
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

                                    <td>
                                        @if(Auth::user()->usuario->tipo_usuario == 'Administrador')
                                            <form method="POST" action="{{ route('gestion.usuarios.update', $usuario->id_usuario) }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="tipo_usuario" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="Usuario" {{ $usuario->tipo_usuario == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                                                    <option value="Entrenador" {{ $usuario->tipo_usuario == 'Entrenador' ? 'selected' : '' }}>Entrenador</option>
                                                    <option value="Administrador" {{ $usuario->tipo_usuario == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                                </select>
                                            </form>
                                        @else
                                            {{ $usuario->tipo_usuario }}
                                        @endif
                                    </td>

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
                    <!-- Paginacion-->
                    <div class="d-flex justify-content-center">
                        {{ $usuarios->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection