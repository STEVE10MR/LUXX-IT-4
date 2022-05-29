@extends('layouts.user')

@section('tittle','home')

@section('content')

@if(Auth::check())
    {{"Lol"}}
@else
    {{"Else"}}
@endif

@endsection
