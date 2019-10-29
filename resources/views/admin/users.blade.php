@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome, {{ $user->name }}</h1>
        <h4>{{ $user->email }}</h4>
        <h4>{{ $user->role }}</h4>
        <h4>{{ $user->phone }}</h4>
    </div>
@endsection