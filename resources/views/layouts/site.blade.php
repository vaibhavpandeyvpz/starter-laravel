@extends('layouts.app', ['body_class' => 'bg-light'])

@section('body')
    <header class="sticky-top shadow-sm">
        @include('partials.navbar.site')
    </header>
    @yield('content')
@endsection
