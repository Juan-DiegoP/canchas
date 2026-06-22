@extends('layouts.app')

@section('title', 'Nueva cancha')

@section('content')
    <h1 class="mb-4">Nueva cancha</h1>

    <form method="POST" action="{{ route('admin.fields.store') }}" class="col-md-8">
        @csrf
        @include('admin.fields._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.fields.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection