@extends('layouts.auth', ['main_columns' => 'col-md-10 col-lg-8 col-xl-6'])

@section('meta')
    <title>{{ __('Register') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Register') }}</h5>
            <p class="card-text">
                {{ __('Register for a free account now.') }}
                {{ __('If you already have an account') }}, <a href="{{ route('login') }}">{{ __('login here') }}</a>.
            </p>
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
                            <input autofocus class="form-control @error('name') is-invalid @enderror" id="register-name" name="name" required value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
                            <input autofocus class="form-control @error('email') is-invalid @enderror" id="register-email" name="email" required type="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-password">{{ __('Password') }} <span class="text-danger">&ast;</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" id="register-password" name="password" required type="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="register-password-confirmation">{{ __('Confirm password') }} <span class="text-danger">&ast;</span></label>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" id="register-password-confirmation" name="password_confirmation" required type="password">
                        </div>
                    </div>
                </div>
                <p>By creating an account with us, you agree having read our <a href="" target="_blank">Privacy Policy</a> and <a href="" target="_blank">Terms of Use</a>.</p>
                <button class="btn btn-secondary">
                    {{ __('Register') }} <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
