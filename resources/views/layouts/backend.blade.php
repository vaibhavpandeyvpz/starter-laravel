@extends('layouts.app')

@section('body')
    <header class="sticky-top mb-3">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        </nav>
    </header>
    @yield('content')
@endsection
