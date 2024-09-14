<head>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container container-create-rutina">
    <div class="row justify-content-center">
        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">
        <div class="col-md-8">
            <div class="card card-create-rutina">
                <div class="card-header card-header-create-rutina">
                    Crear Rutina
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rutinas.store') }}">
                        @csrf
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">

                        <!-- Nombre de la rutina -->
                        <div class="form-group mb-3">
                            <label for="nombre_rutina" class="form-label">Nombre de la Rutina</label>
                            <input type="text" class="form-control" id="nombre_rutina" name="nombre_rutina" required>
                        </div>

                        <!-- Descripción de la rutina -->
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción de la Rutina</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                placeholder="Escribe una descripción de la rutina..."></textarea>
                        </div>

                        <!-- Fecha de inicio -->
                        <div class="form-group mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>

                        <!-- Fecha de fin -->
                        <div class="form-group mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>

                        <!-- Ejercicios para cada día de la semana -->
                        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            <div class="form-group mb-3">
                                <h5 class="text-warning-rutina">{{ $dia }}</h5>

                                <table class="table table-exercises table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Ejercicio</th>
                                            <th>Series</th>
                                            <th>Repeticiones</th>
                                            <th>Minutos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-{{ strtolower($dia) }}">
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-add-exercise"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Ejercicio
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-save-rutina">Guardar Rutina</button>
                            <a href="{{ route('rutinas.index', ['id_usuario' => Auth::user()->usuario->id_usuario]) }}"
                                class="btn btn-back-rutina">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aquí es donde pasamos ejerciciosPorCategoria desde el controlador -->
<script>
    var ejerciciosPorCategoria = @json($ejerciciosPorCategoria);

    // Nombres personalizados de las categorías
    const nombresCategorias = {
        'fuerza': 'Ejercicios de Fuerza',
        'movilidad': 'Ejercicios de Movilidad',
        'cardio': 'Ejercicios de Cardio',
        'resistencia': 'Ejercicios de Resistencia'
    };

    function agregarFila(dia) {
        const tabla = document.getElementById('tabla-' + dia);
        const fila = document.createElement('tr');

        // Crea el selector de ejercicios con las categorías
        let tdEjercicio = document.createElement('td');
        let selectEjercicio = document.createElement('select');
        selectEjercicio.className = 'form-control';
        selectEjercicio.name = 'ejercicio_' + dia + '[]';

        // Rellena el selector de ejercicios por categorías
        for (let categoria in ejerciciosPorCategoria) {
            let optgroup = document.createElement('optgroup');
            optgroup.label = nombresCategorias[categoria] || categoria;

            ejerciciosPorCategoria[categoria].forEach(function (ejercicio) {
                let option = document.createElement('option');
                option.value = ejercicio.id_ejercicio;
                option.text = ejercicio.nombre_ejercicio;
                optgroup.appendChild(option);
            });

            selectEjercicio.appendChild(optgroup);
        }

        tdEjercicio.appendChild(selectEjercicio);
        fila.appendChild(tdEjercicio);

        fila.innerHTML += `
        <td><input type="number" name="series_${dia}[]" class="form-control" placeholder="Series"></td>
        <td><input type="number" name="repeticiones_${dia}[]" class="form-control" placeholder="Repeticiones"></td>
        <td><input type="number" name="minutos_${dia}[]" class="form-control" placeholder="Minutos"></td>
        <td><button type="button" class="btn btn-delete-exercise" onclick="eliminarFila(this)">Eliminar</button></td>
    `;

        tabla.appendChild(fila);
    }

    function eliminarFila(boton) {
        const fila = boton.parentNode.parentNode;
        fila.parentNode.removeChild(fila);
    }
</script>

@endsection
