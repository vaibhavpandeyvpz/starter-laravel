<!doctype html>
<html class="{{ $html_class ?? '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('meta')
        <title>{{ config('app.name') }}</title>
    @show
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">
    @section('styles')
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('css/flatpickr.css') }}" rel="stylesheet">
    @show
    @auth
        <script>
            function logout(e) {
                e.preventDefault();
                document.forms['form-logout'].submit()
            }
        </script>
    @endauth
</head>
<body class="{{ $body_class ?? '' }}">
@auth
    <form action="{{ route('logout') }}" id="form-logout" method="post" style="display: none;">
        @csrf
    </form>
@endauth
@yield('body')
@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@show
</body>
</html>
