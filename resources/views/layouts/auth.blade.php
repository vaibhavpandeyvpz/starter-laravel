@extends('layouts.app', [
    'html_class' => 'h-100',
    'body_class' => 'h-100 d-flex flex-column',
])

@section('body')
    <div class="container my-auto py-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
                <p class="mb-0">
                    @auth
                        <a class="text-body" href="{{ route('logout') }}" onclick="event.preventDefault(); logout()">{{ __('Logout') }}</a>
                        &bull;
                    @endauth
                    <strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
@endsection
