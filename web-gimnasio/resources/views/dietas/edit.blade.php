@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #fff;">
                <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                    Editar Dieta
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('dietas.update', $dietaSeleccionada->id_dieta) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre de la dieta -->
                        <div class="form-group mb-3">
                            <label for="nombre_dieta" class="form-label">Nombre de la Dieta</label>
                            <input type="text" class="form-control" id="nombre_dieta" name="nombre_dieta"
                                value="{{ $dietaSeleccionada->nombre_dieta }}" required>
                        </div>

                        <!-- Descripción de la dieta -->
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción de la Dieta</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                placeholder="Escribe una descripción de la dieta...">{{ $dietaSeleccionada->descripcion }}</textarea>
                        </div>

                        <!-- Fechas -->
                        <div class="form-group mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                value="{{ $dietaSeleccionada->fecha_inicio }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                value="{{ $dietaSeleccionada->fecha_fin }}">
                        </div>

                        <!-- Alimentos para cada día de la semana -->
                        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                            <div class="form-group mb-3">
                                <h5 class="text-warning">{{ $dia }}</h5>

                                <table class="table table-dark table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Alimento</th>
                                            <th>Cantidad</th>
                                            <th>Tiempo de comida</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-{{ strtolower($dia) }}">
                                        @foreach ($alimentosPorDia[$dia] ?? [] as $alimento)
                                            <tr>
                                                <td>
                                                    <select name="alimento_{{ strtolower($dia) }}[]" class="form-control">
                                                        @foreach ($alimentosPorTipo as $tipo => $alimentos)
                                                            <optgroup label="{{ $tipo }}">
                                                                @foreach ($alimentos as $alimentoTipo)
                                                                    <option value="{{ $alimentoTipo->id_alimento }}" {{ $alimento->id_alimento == $alimentoTipo->id_alimento ? 'selected' : '' }}>
                                                                        {{ $alimentoTipo->nombre_alimento }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="cantidad_{{ strtolower($dia) }}[]"
                                                        class="form-control" value="{{ $alimento->cantidad }}"
                                                        placeholder="Cantidad (gr)"></td>
                                                <td>
                                                    <select name="tiempo_comida_{{ strtolower($dia) }}[]" class="form-control">
                                                        <option value="desayuno" {{ $alimento->tiempo_comida == 'desayuno' ? 'selected' : '' }}>Desayuno</option>
                                                        <option value="almuerzo" {{ $alimento->tiempo_comida == 'almuerzo' ? 'selected' : '' }}>Almuerzo</option>
                                                        <option value="cena" {{ $alimento->tiempo_comida == 'cena' ? 'selected' : '' }}>Cena</option>
                                                        <option value="snack" {{ $alimento->tiempo_comida == 'snack' ? 'selected' : '' }}>Snack</option>
                                                    </select>
                                                </td>
                                                <td><button type="button" class="btn btn-danger"
                                                        onclick="eliminarFila(this)">Eliminar</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-success"
                                    onclick="agregarFila('{{ strtolower($dia) }}')">
                                    Añadir Alimento
                                </button>
                            </div>
                        @endforeach

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #ffc107; border-color: #ffc107;">
                                Guardar Cambios
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
    var alimentosPorTipo = @json($alimentosPorTipo);

    function agregarFila(dia) {
        const tabla = document.getElementById('tabla-' + dia);
        const fila = document.createElement('tr');

        // Crea el selector de alimentos con las categorías
        let tdAlimento = document.createElement('td');
        let selectAlimento = document.createElement('select');
        selectAlimento.className = 'form-control';
        selectAlimento.name = 'alimento_' + dia + '[]';

        // Rellena el selector de alimentos por categorías
        for (let tipo in alimentosPorTipo) {
            let optgroup = document.createElement('optgroup');
            optgroup.label = tipo;

            alimentosPorTipo[tipo].forEach(function (alimento) {
                let option = document.createElement('option');
                option.value = alimento.id_alimento;
                option.text = alimento.nombre_alimento;
                optgroup.appendChild(option);
            });

            selectAlimento.appendChild(optgroup);
        }

        tdAlimento.appendChild(selectAlimento);
        fila.appendChild(tdAlimento);

        fila.innerHTML += `
        <td><input type="number" name="cantidad_${dia}[]" class="form-control" placeholder="Cantidad (gr)"></td>
        <td>
            <select name="tiempo_comida_${dia}[]" class="form-control">
                <option value="desayuno">Desayuno</option>
                <option value="almuerzo">Almuerzo</option>
                <option value="cena">Cena</option>
                <option value="snack">Snack</option>
            </select>
        </td>
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