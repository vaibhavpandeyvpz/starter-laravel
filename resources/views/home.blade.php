@extends('layouts.app')

@section('meta')
    <title>{{ __('Home') }} | {{ config('app.name') }}</title>
@endsection

@section('body')
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
    </nav>
    <main class="container-fluid my-3">
        <h1>{{ __('Home') }}</h1>
        <p>
            {{ __('This is what they call it.') }}
            @auth
                <a href="{{ route('logout') }}" onclick="logout(event)">{{ __('Logout') }}?</a>
            @endauth
        </p>
    </main>
@endsection
