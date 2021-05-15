@extends('layouts.auth')

@section('meta')
    <title>{{ __('Forgot Password') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Forgot Password') }}</h5>
            <p class="card-text">{{ __('Enter the email address of your account to receive a password reset link.') }}</p>
            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="forgot-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
                    <input autofocus class="form-control @error('email') is-invalid @enderror" id="forgot-email" name="email" required type="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-secondary">
                    {{ __('Send Link') }} <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
