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
        </div>
    </div>
@endsection
