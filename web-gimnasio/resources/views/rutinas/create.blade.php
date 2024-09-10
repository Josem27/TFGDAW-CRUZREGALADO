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
                                        <!-- Aquí se agregarán dinámicamente los ejercicios -->
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-success"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Ejercicio
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #ffc107; border-color: #ffc107;">
                                Guardar Rutina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para agregar filas dinámicamente -->
<script>
    function agregarFila(dia) {
        const tabla = document.getElementById('tabla-' + dia);
        const fila = document.createElement('tr');

        fila.innerHTML = `
        <td>
            <select name="ejercicio_${dia}[]" class="form-control">
                @foreach($ejercicios as $ejercicio)
                    <option value="{{ $ejercicio->id_ejercicio }}">{{ $ejercicio->nombre_ejercicio }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="series_${dia}[]" class="form-control" placeholder="Series"></td>
        <td><input type="number" name="repeticiones_${dia}[]" class="form-control" placeholder="Repeticiones"></td>
        <td><input type="number" name="minutos_${dia}[]" class="form-control" placeholder="Minutos"></td>
        <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)">Eliminar</button></td>
    `;

        tabla.appendChild(fila);
    }


    function eliminarFila(boton) {
        const fila = boton.parentNode.parentNode;
        fila.parentNode.removeChild(fila);
    }
</script>

@endsection