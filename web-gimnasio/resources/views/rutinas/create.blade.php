@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #fff;">
                <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                    Crear Rutina
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rutinas.store') }}">
                        @csrf

                        <!-- Nombre de la rutina -->
                        <div class="form-group mb-3">
                            <label for="nombre_rutina" class="form-label">Nombre de la Rutina</label>
                            <input type="text" class="form-control" id="nombre_rutina" name="nombre_rutina" required>
                        </div>

                        <!-- Descripcion de la rutina -->
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
                                <h5 class="text-warning">{{ $dia }}</h5>

                                <table class="table table-dark table-bordered">
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

                                <button type="button" class="btn btn-success"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Ejercicio
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-warning">Guardar Rutina
                            </button>
                            <a href="{{ route('dietas.index') }}" class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para agregar filas dinámicamente -->
<script>
    // Ejercicios agrupados por categoría
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

            // Usa el nombre personalizado si existe, si no, usa el nombre original
            optgroup.label = nombresCategorias[categoria] || categoria;

            ejerciciosPorCategoria[categoria].forEach(function (ejercicio) {
                let option = document.createElement('option');
                option.value = ejercicio.id_ejercicio;
                option.text = ejercicio.nombre_ejercicio;
                optgroup.appendChild(option);
            });

            selectEjercicio.appendChild(optgroup);
        }

        // Añadir el select dentro del td
        tdEjercicio.appendChild(selectEjercicio);
        fila.appendChild(tdEjercicio);

        // Crea una nueva fila con los campos de series, repeticiones y minutos
        fila.innerHTML += `
        <td><input type="number" name="series_${dia}[]" class="form-control" placeholder="Series"></td>
        <td><input type="number" name="repeticiones_${dia}[]" class="form-control" placeholder="Repeticiones"></td>
        <td><input type="number" name="minutos_${dia}[]" class="form-control" placeholder="Minutos"></td>
        <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)">Eliminar</button></td>
        `;

        // Añadir la fila a la tabla
        tabla.appendChild(fila);
    }

    function eliminarFila(boton) {
        const fila = boton.parentNode.parentNode;
        fila.parentNode.removeChild(fila);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Asegúrate de que los botones 'Añadir Ejercicio' estén activos después de que el DOM esté cargado
        let botones = document.querySelectorAll('button[data-dia]');
        botones.forEach(boton => {
            boton.addEventListener('click', function () {
                const dia = boton.getAttribute('data-dia');
                agregarFila(dia);
            });
        });
    });
</script>

@endsection