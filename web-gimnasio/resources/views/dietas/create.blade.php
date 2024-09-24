<head>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-create-dieta">
                <div class="card-header text-center header-create-dieta">
                    Crear Dieta
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('dietas.store') }}">
                        @csrf
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">

                        <div class="form-group mb-3">
                            <label for="nombre_dieta" class="form-label">Nombre de la Dieta</label>
                            <input type="text" class="form-control" id="nombre_dieta" name="nombre_dieta" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción de la Dieta</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                placeholder="Escribe una descripción de la dieta..."></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>

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

                                <div class="total-calorias-wrapper text-right">
                                    <strong>Calorías totales del día:</strong>
                                    <span id="total-calorias-{{ strtolower($dia) }}">0</span>
                                </div>

                                <button type="button" class="btn btn-warning mt-2"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Alimento
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-warning">Guardar Dieta
                            </button>
                            <a href="{{ route('dietas.index', ['id_usuario' => Auth::user()->usuario->id_usuario]) }}"
                                class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    var alimentosPorTipo = @json($alimentosPorTipo);

    function agregarFila(dia) {
        const tabla = document.getElementById('tabla-' + dia);
        const fila = document.createElement('tr');

        let tdAlimento = document.createElement('td');
        let selectAlimento = document.createElement('select');
        selectAlimento.className = 'form-control';
        selectAlimento.name = 'alimento_' + dia + '[]';
        selectAlimento.onchange = function () { actualizarCalorias(fila, dia); };

        for (let tipo in alimentosPorTipo) {
            let optgroup = document.createElement('optgroup');
            optgroup.label = tipo;

            alimentosPorTipo[tipo].forEach(function (alimento) {
                let option = document.createElement('option');
                option.value = alimento.id_alimento;
                option.setAttribute('data-calorias', alimento.calorias);
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

    function eliminarFila(boton, dia) {
        const fila = boton.closest('tr');
        fila.remove();
        actualizarTotalCalorias(dia);
    }

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

    function actualizarTotalCalorias(dia) {
        let totalCalorias = 0;
        const filas = document.querySelectorAll(`#tabla-${dia} .calorias`);
        filas.forEach(function (td) {
            totalCalorias += parseFloat(td.textContent) || 0;
        });

        document.getElementById(`total-calorias-${dia}`).textContent = totalCalorias.toFixed(2);
    }
</script>