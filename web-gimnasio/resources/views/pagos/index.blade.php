@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @include('partials.menu')

    <div class="tab-content" style="background-color: #333; color: #fff; padding: 20px; border-radius: 5px;">
        <div class="tab-pane fade show active">
            <h3>Historial de Pagos</h3>
            <p>Aquí puedes consultar tus pagos realizados.</p>

            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Fecha del Pago</th>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Método de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>{{ $pago->estado_pago }}</td>
                            <td>{{ $pago->cantidad }} €</td>
                            <td>{{ ucfirst($pago->método_pago) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(Auth::user()->usuario->tipo_usuario == 'Administrador' || Auth::user()->usuario->tipo_usuario == 'Entrenador')
            <h3>Añadir/Actualizar Pago</h3>
            <form action="{{ route('pagos.store', ['id_usuario' => $id_usuario ?? Auth::user()->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="método_pago">Método de Pago</label>
                    <select name="método_pago" class="form-control" required>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="estado_pago">Estado</label>
                    <select name="estado_pago" class="form-control" required>
                        <option value="completado">Completado</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="fallido">Fallido</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning mt-3">Guardar Pago</button>
            </form>
        @endif
    </div>
</div>
@endsection