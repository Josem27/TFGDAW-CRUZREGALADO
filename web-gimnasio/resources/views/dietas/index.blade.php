@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('partials.menu')

        <div class="tab-content tab-content-dietas">
            <div class="tab-pane fade show active">
                <h3>Planes de Dieta</h3>
                <p>Aquí puedes ver y gestionar tus dietas personalizadas.</p>
                <a href="{{ route('dietas.create', ['id_usuario' => $idUsuarioActual]) }}" class="btn btn-warning">Añadir Dieta</a>

                <form method="GET" action="{{ route('dietas.index', ['id_usuario' => $idUsuarioActual]) }}">
                    <div class="form-group">
                        <label for="dieta-select" class="text-warning">Selecciona una dieta:</label>
                        <select name="dieta_id" id="dieta-select" class="form-select mb-3" onchange="this.form.submit()">
                            <option selected>Selecciona una dieta</option>
                            @foreach($dietas as $dieta)
                                <option value="{{ $dieta->id_dieta }}" {{ request('dieta_id') == $dieta->id_dieta ? 'selected' : '' }}>
                                    {{ $dieta->nombre_dieta }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if($dietaSeleccionada)
                    <div class="dieta-detalle">
                        <h5 class="text-warning">Información de la dieta seleccionada</h5>
                        <p><strong>Descripción:</strong> {{ $dietaSeleccionada->descripcion ?? 'Sin descripción' }}</p>
                        <p><strong>Fecha de inicio:</strong> {{ $dietaSeleccionada->fecha_inicio }}</p>
                        <p><strong>Fecha de fin:</strong> {{ $dietaSeleccionada->fecha_fin }}</p>

                        <div class="mb-3">
                            <a href="{{ route('dietas.edit', ['id' => $dietaSeleccionada->id_dieta]) }}" class="btn btn-warning">Editar Dieta</a>
                            
                            <form method="POST" action="{{ route('dietas.destroy', ['id' => $dietaSeleccionada->id_dieta]) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('¿Estás seguro de que deseas eliminar esta dieta?');">
                                    Eliminar Dieta
                                </button>
                            </form>
                        </div>

                        @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                            <div class="form-group mb-3">
                                <h5 class="text-warning">{{ $dia }}</h5>
                                <table class="table table-dark table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Alimento</th>
                                            <th>Cantidad</th>
                                            <th>Tiempo de comida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($alimentosPorDia[$dia] ?? [] as $alimento)
                                            <tr>
                                                <td>{{ $alimento->nombre_alimento }}</td>
                                                <td>{{ $alimento->cantidad }}</td>
                                                <td>{{ $alimento->tiempo_comida }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="total-calorias text-right mt-2">
                                    <strong>Total de calorías:</strong> 
                                    {{ $caloriasTotalesPorDia[$dia] ?? 0 }} kcal
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection