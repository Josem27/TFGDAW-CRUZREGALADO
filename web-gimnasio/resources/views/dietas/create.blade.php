@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #fff;">
                <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                    Crear Dieta
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('dietas.store') }}">
                        @csrf

                        <!-- Nombre de la dieta -->
                        <div class="form-group mb-3">
                            <label for="nombre_dieta" class="form-label">Nombre de la Dieta</label>
                            <input type="text" class="form-control" id="nombre_dieta" name="nombre_dieta" required>
                        </div>

                        <!-- Descripción de la dieta -->
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción de la Dieta</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                placeholder="Escribe una descripción de la dieta..."></textarea>
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

                        <!-- Alimentos para cada día de la semana -->
                        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            <div class="form-group mb-3">
                                <h5 class="text-warning">{{ $dia }}</h5>

                                <table class="table table-dark table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Alimento</th>
                                            <th>Cantidad (gr)</th>
                                            <th>Tiempo de Comida</th>
                                            <th>Calorías</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-{{ strtolower($dia) }}">
                                    </tbody>
                                </table>

                                <!-- Total de calorías fuera de la tabla -->
                                <div class="total-calorias-wrapper text-right">
                                    <strong>Calorías totales del día:</strong>
                                    <span id="total-calorias-{{ strtolower($dia) }}">0</span>
                                </div>

                                <button type="button" class="btn btn-success mt-2"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Alimento
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #ffc107; border-color: #ffc107;">
                                Guardar Dieta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para agregar filas dinámicamente y calcular calorías -->
<script>
    // Alimentos agrupados por tipo
    var alimentosPorTipo = @json($alimentosPorTipo);

    // Función para agregar una fila de alimentos en un día específico
    function agregarFila(dia) {
        const tabla = document.getElementById('tabla-' + dia);
        const fila = document.createElement('tr');

        // Crea el selector de alimentos con los tipos (sin mostrar el tipo)
        let tdAlimento = document.createElement('td');
        let selectAlimento = document.createElement('select');
        selectAlimento.className = 'form-control';
        selectAlimento.name = 'alimento_' + dia + '[]';
        selectAlimento.onchange = function() { actualizarCalorias(fila, dia); };

        // Rellena el selector de alimentos por tipos sin mostrar el tipo explícitamente
        for (let tipo in alimentosPorTipo) {
            let optgroup = document.createElement('optgroup');
            optgroup.label = tipo;  // Esto se puede mantener solo a nivel visual, no editable por el usuario

            alimentosPorTipo[tipo].forEach(function (alimento) {
                let option = document.createElement('option');
                option.value = alimento.id_alimento;
                option.setAttribute('data-calorias', alimento.calorias);  // Añadimos las calorías del alimento
                option.text = alimento.nombre_alimento;
                optgroup.appendChild(option);
            });

            selectAlimento.appendChild(optgroup);
        }

        tdAlimento.appendChild(selectAlimento);
        fila.appendChild(tdAlimento);

        // Crear una nueva fila con los campos de cantidad y tiempo de comida
        fila.innerHTML += `
            <td><input type="number" name="cantidad_${dia}[]" class="form-control" placeholder="Cantidad (gr)" oninput="actualizarCalorias(this.closest('tr'), '${dia}')"></td>
            <td>
                <select name="tiempo_comida_${dia}[]" class="form-control">
                    <option value="desayuno">Desayuno</option>
                    <option value="almuerzo">Almuerzo</option>
                    <option value="cena">Cena</option>
                    <option value="snack">Snack</option>
                </select>
            </td>
            <td class="calorias">0</td>
            <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this, '${dia}')">Eliminar</button></td>
        `;

        tabla.appendChild(fila);
    }

    // Función para eliminar una fila
    function eliminarFila(boton, dia) {
        const fila = boton.closest('tr');
        fila.remove();
        actualizarTotalCalorias(dia);
    }

    // Función para actualizar las calorías de una fila
    function actualizarCalorias(fila, dia) {
        const selectAlimento = fila.querySelector('select');
        const inputCantidad = fila.querySelector('input');
        const caloriasTd = fila.querySelector('.calorias');

        // Obtener las calorías del alimento seleccionado
        const caloriasPor100g = selectAlimento.options[selectAlimento.selectedIndex].getAttribute('data-calorias');
        const cantidad = inputCantidad.value;

        // Calcular calorías totales en función de la cantidad ingresada
        const calorias = (caloriasPor100g * cantidad) / 100;

        caloriasTd.textContent = isNaN(calorias) ? '0' : calorias.toFixed(2);

        actualizarTotalCalorias(dia);
    }

    // Función para actualizar las calorías totales de un día
    function actualizarTotalCalorias(dia) {
        let totalCalorias = 0;
        const filas = document.querySelectorAll(`#tabla-${dia} .calorias`);
        filas.forEach(function(td) {
            totalCalorias += parseFloat(td.textContent) || 0;
        });

        document.getElementById(`total-calorias-${dia}`).textContent = totalCalorias.toFixed(2);
    }
</script>

<style>
    .total-calorias-wrapper {
        margin-top: -10px;  /* Ajuste para estar justo debajo de la tabla */
        text-align: right;
        font-size: 16px;
    }
</style>

@endsection
