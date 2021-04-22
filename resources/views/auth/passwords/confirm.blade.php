@extends('layouts.auth')

@section('meta')
    <title>{{ __('Confirmation') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Confirm Password') }}</h5>
            <p class="card-text">{{ __('Please confirm your password before continuing.') }}</p>
            <form method="post" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label for="login-password">{{ __('Password') }} <span class="text-danger">&ast;</span></label>
                    <input autofocus class="form-control @error('password') is-invalid @enderror" id="login-password" name="password" required type="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-secondary">
                    {{ __('Confirm') }} <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
