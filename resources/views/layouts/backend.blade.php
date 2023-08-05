@extends('layouts.app', ['body_class' => 'bg-light'])

@push('styles')
    @vite('resources/styl/flatpickr.styl')
    @livewireStyles
@endpush

@section('body')
    <header class="sticky-top shadow-sm mb-3">
        @include('partials.navbar.backend')
    </header>
    <div class="container">
        @yield('breadcrumbs')
        @include('flash::message')
        @stack('flash')
    </div>
    <main class="container mb-3">
        @yield('content')
    </main>
    <footer class="container">
        <p class="text-muted">{{ config('app.name', 'Laravel') }} &copy; {{ date('Y') }}</p>
    </footer>
@endsection

@push('scripts')
    @livewireScripts
@endpush
