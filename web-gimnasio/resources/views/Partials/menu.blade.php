<head>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

<ul class="nav nav-tabs">
    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">Mi Perfil</a>
    </li>
    <li class="nav-item {{ request()->is('rutinas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rutinas.index', ['id_usuario' => Auth::user()->id]) }}">Rutinas</a>
    </li>
    <li class="nav-item {{ request()->is('dietas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dietas.index', ['id_usuario' => Auth::user()->id]) }}">Dietas</a>
    </li>
    <li class="nav-item {{ request()->is('pagos*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pagos.index', ['id_usuario' => Auth::user()->id]) }}">Pagos</a>
    </li>

    @if(Auth::user() && Auth::user()->usuario && (Auth::user()->usuario->tipo_usuario == 'Administrador' ||
    Auth::user()->usuario->tipo_usuario == 'Entrenador'))
    <li class="nav-item {{ request()->is('gestion-usuarios') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gestion.usuarios.index') }}">Gestión de Usuarios</a>
    </li>
    @endif
</ul>