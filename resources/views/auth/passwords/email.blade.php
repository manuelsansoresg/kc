
@extends('layouts.auth_template')

@section('content')
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                    <div class="brand-logo pb-4 text-center">
                        <a href="/" class="logo-link">
                            <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png"  alt="logo-dark">
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    
                                    <h5 class="nk-block-title">Restablecer contraseña</h5>
                                    <div class="nk-block-des">
                                        <p>Si olvidaste tu contraseña, te enviaremos instrucciones para restablecerla.</p>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Correo electrónico</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        
                                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">Enviar enlace de restablecimiento</button>
                                </div>
                            </form>
                            <div class="form-note-s2 text-center pt-4">
                                <a href="/login"><strong>Volver al inicio de sesión</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->


{{-- <div class="container">
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> --}}
@endsection

