@extends('layouts.app')

@section('content')
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.8); color: #ffc107; border: none;">
                    <div class="card-header text-center" style="font-size: 24px; font-weight: bold; color: #ffc107;">
                        {{ __('Confirma tu correo electrónico') }}
                    </div>

                    <div class="card-body" style="color: #fff;">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert" style="color: #ffc107;">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                            </div>
                        @endif

                        {{ __('Antes de continuar, por favor revisa tu correo electrónico para un enlace de verificación.') }}
                        {{ __('Si no recibiste el correo electrónico') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: #ffc107;">{{ __('haz clic aquí para solicitar otro') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
