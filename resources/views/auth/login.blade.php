@extends('layouts.auth')

@section('meta')
    <title>{{ __('Login') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Login') }}
    </h1>
    @if ($message = session('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif
    <p class="card-text">
        {{ __('Enter credentials below to login into your account registered with us.') }}
    </p>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="login-email">
                {{ __('Email') }} <span class="text-danger">&ast;</span>
            </label>
            <input autofocus class="form-control form-control-lg @error('email') is-invalid @enderror" id="login-email" name="email" required type="email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-1">
            <label class="form-label" for="login-password">
                {{ __('Password') }} <span class="text-danger">&ast;</span>
            </label>
            <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="login-password" name="password" type="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <p class="text-end">
            <small>
                {{ __('Forgot password?') }} <a href="{{ route('password.request') }}">{{ __('Reset here') }}</a>.
            </small>
        </p>
        <div class="form-check">
            <input class="form-check-input" id="login-remember" name="remember" type="checkbox" value="1" @if (old('remember')) checked @endif>
            <label class="form-check-label" for="login-remember">
                {{ __('Do not ask again') }}
            </label>
        </div>
        @if (Route::has('register'))
            <div class="d-flex align-items-center my-3">
                <hr class="w-100">
                <span class="text-uppercase px-3">{{ __('Or') }}</span>
                <hr class="w-100">
            </div>
            <p><a href="{{ route('register') }}">Register here</a> if you do not have an account yet.</p>
        @endif
        <div class="btn-toolbar justify-content-end @if (!Route::has('register')) mt-3 @endif">
            <button class="btn btn-primary btn-lg">
                {{ __('Login') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
@endsection
