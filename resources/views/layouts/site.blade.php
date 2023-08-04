@extends('layouts.app')

@section('body')
    <header class="sticky-top shadow-sm">
        @include('partials.navbar.site')
    </header>
    @yield('content')
@endsection
