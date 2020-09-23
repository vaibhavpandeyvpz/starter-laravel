@extends('layouts.auth')

@section('meta')
    <title>{{ __('Reset Password') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Reset Password') }}</h5>
            <p class="card-text">{{ __('Enter your email address and desired password twice to regain access to your account.') }}</p>
            <form action="{{ route('password.request') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="reset-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
                    <input autofocus class="form-control @error('email') is-invalid @enderror" id="reset-email" name="email" required type="email" value="{{ $email ?? old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="reset-password">{{ __('Password') }} <span class="text-danger">&ast;</span></label>
                    <input class="form-control @error('password') is-invalid @enderror" id="reset-password" name="password" required type="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="reset-password-confirm">{{ __('Confirm password') }} <span class="text-danger">&ast;</span></label>
                    <input class="form-control" id="reset-password-confirm" name="password_confirmation" required type="password">
                </div>
                <button class="btn btn-secondary">
                    {{ __('Reset Password') }} <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
