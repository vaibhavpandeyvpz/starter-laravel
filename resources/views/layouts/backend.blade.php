@extends('layouts.app')

@section('styles')
    @parent
    @livewireStyles
@show

@section('body')
    <header class="sticky-top shadow-sm">
        @include('partials.navbar.backend')
    </header>
    @yield('content')
@endsection

@section('scripts')
    @parent
    @livewireScripts
@show
