@extends('layouts.app')

@section('title', 'Editar deporte')

@section('content')
    <h1 class="mb-4">Editar deporte</h1>

    <form method="POST" action="{{ route('admin.sport-types.update', $sportType) }}" class="col-md-6">
        @csrf
        @method('PUT')
        @include('admin.sport_types._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.sport-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection