@extends('layouts.backend')

@section('content')
    <main class="container my-3">
        <h1>Dashboard</h1>
        <p>You are logged in! <a href="{{ route('logout') }}" onclick="logout(event)">Logout</a>?</p>
    </main>
@endsection
