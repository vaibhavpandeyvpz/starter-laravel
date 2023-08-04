@extends('layouts.auth')

@section('meta')
    <title>{{ __('Confirm Password') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Confirm password') }}
    </h1>
    <p class="card-text">
        {{ __('This is a secure area of the application.') }}
        {{ __('Please confirm your password before continuing.') }}
    </p>
    <form action="{{ route('password.confirm') }}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="confirm-password">
                {{ __('Password') }} <span class="text-danger">&ast;</span>
            </label>
            <input autofocus class="form-control form-control-lg @error('password') is-invalid @enderror" id="confirm-password" name="password" required type="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="btn-toolbar justify-content-end">
            <button class="btn btn-primary btn-lg">
                {{ __('Continue') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
@endsection
