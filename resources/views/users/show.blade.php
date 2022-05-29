@extends('layouts.app')
@section('title','Listar')
@section('content')
<h1>Usuarios</h1>

@if(Auth::check())
    {{ "Autentificado"}}
    <br>
    @forelse ($users as $value)
        <a href="{{route('users.edit',$value)}}">{{$value->name}}</a>
        <br>
    @empty
        {{ "Vacio" }}
    @endforelse
@else
    {{ "No Autetificado" }}
@endif


@endsection
