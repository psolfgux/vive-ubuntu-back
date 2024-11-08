@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create')

@section('content')
    <h4>Create</h4>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tematicas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" class="form-control" id="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="form-group">
            <label for="orden">Orden</label>
            <input type="number" name="orden" class="form-control" id="orden" value="{{ old('orden') }}" required>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="color" name="color" class="form-control" id="color" value="{{ old('color', '#000000') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Crear Temática</button>
        <a href="{{ route('tematicas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection