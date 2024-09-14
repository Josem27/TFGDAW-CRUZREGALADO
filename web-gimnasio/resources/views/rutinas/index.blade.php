@extends('layouts.app')

@section('content')
<div class="container container-rutinas">
    @include('partials.menu')

    <div class="tab-content card-rutinas">
        <div class="tab-pane fade show active">
            <h3>Rutinas de Entrenamiento</h3>
            <p>Aquí puedes ver y gestionar tus rutinas personalizadas.</p>
            <a href="{{ route('rutinas.create', ['id_usuario' => $idUsuarioActual]) }}" class="btn btn-add-rutina">Añadir
                Rutina</a>
            <form method="GET" action="{{ route('rutinas.index', ['id_usuario' => $idUsuarioActual]) }}">
                <div class="form-group form-group-rutinas">
                    <label for="rutina-select" class="text-warning-rutinas">Selecciona una rutina:</label>
                    <select name="rutina_id" id="rutina-select" class="form-select mb-3" onchange="this.form.submit()">
                        <option selected>Selecciona una rutina</option>
                        @foreach($rutinas as $rutina)
                            <option value="{{ $rutina->id_rutina }}" {{ request('rutina_id') == $rutina->id_rutina ? 'selected' : '' }}>
                                {{ $rutina->nombre_rutina }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if($rutinaSeleccionada)
                <div class="rutina-detalle">
                    <h5 class="text-warning-rutinas">Información de la rutina seleccionada</h5>
                    <p><strong>Descripción:</strong> {{ $rutinaSeleccionada->descripcion ?? 'Sin descripción' }}</p>
                    <p><strong>Fecha de creación:</strong> {{ $rutinaSeleccionada->fecha_inicio }}</p>
                    <p><strong>Fecha esperada de finalización:</strong> {{ $rutinaSeleccionada->fecha_fin }}</p>

                    <div class="mb-3">
                        <a href="{{ route('rutina.edit', ['id' => $rutinaSeleccionada->id_rutina]) }}"
                            class="btn btn-edit-rutina">Editar Rutina</a>

                        <form method="POST" action="{{ route('rutina.destroy', ['id' => $rutinaSeleccionada->id_rutina]) }}"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete-rutina"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta rutina?');">
                                Eliminar Rutina
                            </button>
                        </form>
                    </div>

                    @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                        <div class="form-group form-group-rutinas">
                            <h5 class="text-warning-rutinas">{{ $dia }}</h5>
                            <table class="table table-ejercicios table-bordered">
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
    </div>
</div>
@endsection