@extends('layouts.app')

@section('title', 'Profile')

@section('content_header')
<h1>Profile</h1>
@stop




@section('content')

@if (Auth::user() && Auth::user()->hasRole('admim'))
<p>Bem-vindo, Administrador! Seu ID é: {{ Auth::user()->id}}</p>
@endif
<h2>Profile content</h2>



@endsection