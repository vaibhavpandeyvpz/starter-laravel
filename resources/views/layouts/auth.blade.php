@extends('layouts.app', [
    'html_class' => 'w-100 h-100',
    'body_class' => 'w-100 h-100 d-flex',
])

@section('body')
    <div class="container my-auto py-3">
        <div class="row justify-content-center">
            <main class="{{ $main_columns ?? 'col-md-6 col-xl-4' }}">
                @yield('content')
                <p class="text-right mb-0">
                    <small>
                        @auth
                            <a href="{{ route('logout') }}" onclick="logout(event)">{{ __('Logout?') }}</a>
                            &hyphen;
                        @endauth
                        <strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}
                    </small>
                </p>
            </main>
        </div>
    </div>
@endsection
