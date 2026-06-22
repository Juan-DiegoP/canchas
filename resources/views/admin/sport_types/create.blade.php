@extends('layouts.app')

@section('title', 'Nuevo deporte')

@section('content')
    <h1 class="mb-4">Nuevo deporte</h1>

    <form method="POST" action="{{ route('admin.sport-types.store') }}" class="col-md-6">
        @csrf
        @include('admin.sport_types._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.sport-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection