@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Navegación de pestañas -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <ul class="nav nav-tabs" id="myTab" role="tablist"
                style="font-weight: bold; background-color: #ffc107; border-radius: 5px;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active text-white" id="mi-perfil-tab" data-bs-toggle="tab" href="#mi-perfil"
                        role="tab" aria-controls="mi-perfil" aria-selected="true">
                        <i class="bi bi-person"></i> Mi Perfil
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-white" id="rutinas-tab" data-bs-toggle="tab" href="#rutinas" role="tab"
                        aria-controls="rutinas" aria-selected="false">
                        <i class="bi bi-list-check"></i> Rutinas
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-white" id="dietas-tab" data-bs-toggle="tab" href="#dietas" role="tab"
                        aria-controls="dietas" aria-selected="false">
                        <i class="bi bi-heart-pulse"></i> Dietas
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-white" id="pagos-tab" data-bs-toggle="tab" href="#pagos" role="tab"
                        aria-controls="pagos" aria-selected="false">
                        <i class="bi bi-credit-card"></i> Pagos
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-white" id="gestion-tab" data-bs-toggle="tab" href="#gestion" role="tab"
                        aria-controls="gestion" aria-selected="false">
                        <i class="bi bi-people"></i> Gestión de Usuarios
                    </a>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class="tab-content" id="myTabContent"
                style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
                <div class="tab-pane fade show active" id="mi-perfil" role="tabpanel" aria-labelledby="mi-perfil-tab">
                    <!-- Contenido del Perfil -->
                    <h3>Bienvenido, {{ Auth::user()->name }}</h3>
                    <p>Este es tu perfil. Aquí puedes actualizar tu información personal.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Editar Perfil</a>
                </div>

                <div class="tab-pane fade" id="rutinas" role="tabpanel" aria-labelledby="rutinas-tab">
                    <!-- Contenido de Rutinas -->
                    <h3>Rutinas de Entrenamiento</h3>
                    <p>Aquí puedes ver y gestionar tus rutinas personalizadas.</p>
                    <a href="{{ route('rutina.create') }}" class="btn btn-warning">Añadir Rutina</a>

                    <!-- Mostrar rutinas -->
                    <form method="GET" action="{{ route('home') }}">
                        <div class="form-group">
                            <label for="rutina-select" class="text-warning">Selecciona una rutina:</label>
                            <select name="rutina_id" id="rutina-select" class="form-select mb-3"
                                onchange="this.form.submit()">
                                <option selected>Selecciona una rutina</option>
                                @foreach($rutinas as $rutina)
                                    <option value="{{ $rutina->id_rutina }}" {{ request('rutina_id') == $rutina->id_rutina ? 'selected' : '' }}>
                                        {{ $rutina->nombre_rutina }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Detalles de la Rutina seleccionada -->
                    @if($rutinaSeleccionada)
                        <div class="rutina-detalle">
                            <h5 class="text-warning">Información de la rutina seleccionada</h5>
                            <p><strong>Fecha de creación:</strong> {{ $rutinaSeleccionada->fecha_inicio }}</p>
                            <p><strong>Fecha esperada de finalización:</strong> {{ $rutinaSeleccionada->fecha_fin }}</p>

                            <!-- Mostrar ejercicios por día -->
                            @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                <div class="form-group mb-3">
                                    <h5 class="text-warning">{{ $dia }}</h5>
                                    <table class="table table-dark table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ejercicio</th>
                                                <th>Repeticiones</th>
                                                <th>Series</th>
                                                <th>Minutos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ejerciciosPorDia[$dia] ?? [] as $ejercicio)
                                                <tr>
                                                    <td>{{ $ejercicio->nombre_ejercicio }}</td>
                                                    <td>{{ $ejercicio->repeticiones ?? 'N/A'}}</td>
                                                    <td>{{ $ejercicio->series ?? 'N/A'}}</td>
                                                    <td>{{ $ejercicio->minutos ?? 'N/A'}}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="dietas" role="tabpanel" aria-labelledby="dietas-tab">
                    <!-- Contenido de Dietas -->
                    <h3>Planes de Dieta</h3>
                    <p>Aquí puedes consultar y seguir tus planes de alimentación.</p>
                </div>

                <div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
                    <!-- Contenido de Pagos -->
                    <h3>Historial de Pagos</h3>
                    <p>Aquí puedes consultar tus pagos realizados y próximos vencimientos.</p>
                </div>

                <div class="tab-pane fade" id="gestion" role="tabpanel" aria-labelledby="gestion-tab">
                    <!-- Contenido de Gestión de Usuarios -->
                    <h3>Gestión de Usuarios</h3>
                    <p>Aquí puedes gestionar a los usuarios registrados.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        color: #fff !important;
        /* Color de las pestañas no activas */
    }

    .nav-tabs .nav-link.active {
        background-color: #333 !important;
        color: #ffc107 !important;
        /* Color de las pestañas activas */
        border-color: transparent;
        /* Para que no haya borde entre la pestaña y el contenido */
    }

    .nav-tabs .nav-link:hover {
        color: #ffc107 !important;
        /* Cambia el color al pasar el mouse */
    }
</style>
@endsection