@extends('layouts.auth')

@section('meta')
    <title>{{ __('Reset Your Password') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Reset your password') }}
    </h1>
    @if ($message = session('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif
    <p class="card-text">
        {{ __('Enter your email below to receive a password reset link on your registered email.') }}
    </p>
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <label class="form-label" for="request-email">
            {{ __('Email') }} <span class="text-danger">&ast;</span>
        </label>
        <input autofocus class="form-control form-control-lg @error('email') is-invalid @enderror" id="request-email" name="email" required type="email" value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="d-flex align-items-center my-3">
            <hr class="w-100">
            <span class="text-uppercase px-3">{{ __('Or') }}</span>
            <hr class="w-100">
        </div>
        <p><a href="{{ route('login') }}">Login here</a> if you remember your password.</p>
        <div class="btn-toolbar justify-content-end">
            <button class="btn btn-primary btn-lg">
                {{ __('Send link') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
@endsection
