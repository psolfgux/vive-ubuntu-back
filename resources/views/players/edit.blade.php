@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Editar tematica</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('tematicas.update', $tematica->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-floating form-floating-outline mb-5">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="titulo" 
                        placeholder="Titulo" 
                        name="titulo" 
                        aria-label="Titulo" 
                        required
                        value="{{ old('titulo', $tematica->titulo) }}"
                    />
                    <label for="titulo">Titulo</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <textarea id="descripcion" name="descripcion" class="form-control h-px-100" rows="3" required>{{ old('descripcion', $tematica->descripcion) }}</textarea>
                    <label for="descripcion">Descripción</label>
                </div>
                
                <div class="form-floating form-floating-outline mb-5">
                    <input type="number" name="orden" class="form-control" id="orden" required placeholder="0" value="{{ old('orden', $tematica->orden) }}">
                    <label for="orden">Orden</label>
                </div>
              
                <div class="form-floating form-floating-outline mb-5">
                    <input type="color" name="color" class="form-control" id="color" required value="{{ old('color', $tematica->color) }}">
                    <label for="color">Color</label>
                </div>
        
                <button type="submit" class="btn btn-primary">Actualizar Temática</button>
                <a href="{{ route('tematicas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>

        </div>
    </div>
@endsection