<ul class="nav nav-tabs" id="myTab" role="tablist" style="font-weight: bold; background-color: #ffc107; border-radius: 5px;">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ request()->is('perfil') ? 'active' : '' }} text-white" href="{{ route('home') }}">
            <i class="bi bi-person"></i> Mi Perfil
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ request()->is('rutinas') ? 'active' : '' }} text-white" href="{{ route('rutinas.index') }}">
            <i class="bi bi-list-check"></i> Rutinas
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ request()->is('dietas') ? 'active' : '' }} text-white" href="{{ route('dietas.index') }}">
            <i class="bi bi-heart-pulse"></i> Dietas
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ request()->is('pagos') ? 'active' : '' }} text-white" href="{{ route('pagos.index') }}">
            <i class="bi bi-credit-card"></i> Pagos
        </a>
    </li>

    @if(Auth::user()->usuario->tipo_usuario == 'administrador' || Auth::user()->usuario->tipo_usuario == 'entrenador')
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request()->is('gestion-usuarios') ? 'active' : '' }} text-white" href="{{ route('gestion.usuarios.index') }}">
                <i class="bi bi-people"></i> Gestión de Usuarios
            </a>
        </li>
    @endif
</ul>