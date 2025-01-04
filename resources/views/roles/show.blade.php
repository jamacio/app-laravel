@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Role Details</h1>
    <p>ID: {{ $role->id }}</p>
    <p>Name: {{ $role->name }}</p>
    <a href="{{ route('roles.index') }}" class="btn btn-primary">Back to Roles</a>
</div>
@endsection