@extends('layouts.app')

@section('styles')
    @parent
    @livewireStyles
@endsection

@section('body')
    @php
        $user = Auth::user();
    @endphp
    <header class="sticky-top mb-3">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand" href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="navbar-nav">
                    <li class="nav-item @if (Route::is('backend.dashboard')) active @endif">
                        <a class="nav-link" href="{{ route('backend.dashboard') }}">
                            <i class="fas fa-columns fa-fw mr-1"></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                    @can('viewAny', App\User::class)
                        <li class="nav-item @if (Route::is('backend.users.*')) active @endif">
                            <a class="nav-link" href="{{ route('backend.users.index') }}">
                                <i class="fas fa-user-friends fa-fw mr-1"></i> {{ __('Users') }}
                            </a>
                        </li>
                    @endcan
                    @can('viewAny', App\Role::class)
                        <li class="nav-item @if (Route::is('backend.roles.*')) active @endif">
                            <a class="nav-link" href="{{ route('backend.roles.index') }}">
                                <i class="fas fa-key fa-fw mr-1"></i> {{ __('Roles') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="dropdown-account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-id-card-alt fa-fw mr-1"></i>
                            <span class="d-md-none">{{ __('More') }}</span>
                            <span class="d-none d-md-inline">{{ __('Hi, :name', ['name' => Auth::user()->name]) }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-account">
                            <a class="dropdown-item @if (Route::is('backend.profile')) active @endif" href="{{ route('backend.profile') }}">{{ __('Profile') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(event)">{{ __('Logout') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        @yield('breadcrumb')
        @section('alerts')
            @include('flash::message')
        @show
    </div>
    @yield('content')
    <footer class="container my-3">
        <strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}.
    </footer>
@endsection

@section('scripts')
    @parent
    @livewireScripts
@endsection
