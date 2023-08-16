<!doctype html>
<html class="{{ $html_class ?? '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @section('meta')
        <title>{{ config('app.name') }}</title>
    @show
    @section('styles')
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" rel="stylesheet">
        @vite('resources/sass/app.scss')
        @stack('styles')
    @show
    @auth
        <script>
            function logout() {
                document.forms['logout-form'].submit();
            }
        </script>
    @endauth
</head>
<body class="{{ $body_class ?? '' }}">
@if (Auth::check())
    <form action="{{ route('logout') }}" method="post" name="logout-form">
        @csrf
    </form>
@endif
@yield('body')
@section('scripts')
    <script src="//unpkg.com/@alpinejs/collapse" defer></script>
    <script src="//unpkg.com/@alpinejs/persist" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/js/app.js')
    @stack('scripts')
@show
</body>
</html>
