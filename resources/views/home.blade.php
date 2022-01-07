@extends('layouts.app')

@section('meta')
    <title>{{ __('Home') }} | {{ config('app.name') }}</title>
@endsection

@section('body')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-home" aria-controls="navbar-home" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-home">
            <div class="navbar-nav ml-lg-auto">
                @auth
                    <a class="nav-link" href="{{ route('backend.dashboard') }}">{{ __('Backend') }}</a>
                @else
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @endauth
            </div>
        </div>
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
