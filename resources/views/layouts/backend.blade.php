@extends('layouts.app')

@push('styles')
    @vite('resources/styl/flatpickr.styl')
@endpush

@section('body')
    <header class="sticky-top shadow-sm mb-3">
        @include('partials.navbar.backend')
    </header>
    <div class="container">
        @yield('breadcrumbs')
        @include('flash::message')
        @stack('alerts')
    </div>
    <main class="container mb-3">
        @yield('content')
    </main>
    <footer>
        <p class="text-center">{{ config('app.name', 'Laravel') }} &copy; {{ date('Y') }}</p>
    </footer>
@endsection
