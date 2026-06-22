@extends('layouts.app')

@section('title', 'Nuevo complejo')

@section('content')
    <h1 class="mb-4">Nuevo complejo</h1>

    <form method="POST" action="{{ route('admin.venues.store') }}" enctype="multipart/form-data" class="col-md-8">
        @csrf
        @include('admin.venues._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection