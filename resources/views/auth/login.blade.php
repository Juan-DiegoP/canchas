@extends('layouts.guest')

@section('title', 'Iniciar sesión')

@section('content')
    <h4 class="mb-3 text-center">Iniciar sesión</h4>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Recordarme</label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Entrar</button>
        </div>

        <div class="text-center mt-3">
            @if (Route::has('password.request'))
                <a class="d-block small mb-2" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
            <span class="small">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></span>
        </div>
    </form>
@endsection