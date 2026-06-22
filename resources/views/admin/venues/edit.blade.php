@extends('layouts.app')

@section('title', 'Editar complejo')

@section('content')
    <h1 class="mb-4">Editar complejo</h1>

    <form method="POST" action="{{ route('admin.venues.update', $venue) }}" enctype="multipart/form-data" class="col-md-8">
        @csrf
        @method('PUT')
        @include('admin.venues._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
@endsection