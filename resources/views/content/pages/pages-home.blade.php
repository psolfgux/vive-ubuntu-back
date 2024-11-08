@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
<h4>Estadisticas</h4>
<div class="container">

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Temáticas Iniciadas</th>
                <th>Cartas Leídas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
                <tr>
                    <td>{{ $player->id }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->email }}</td>
                    <td>{{ $player->tematicas_count }}</td>
                    <td>{{ $player->read_cards_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
