@extends('layouts.app')

@section('title', 'Editar cancha')

@section('content')
    <h1 class="mb-4">Editar cancha</h1>

    <form method="POST" action="{{ route('admin.fields.update', $field) }}" class="col-md-8">
        @csrf
        @method('PUT')
        @include('admin.fields._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection