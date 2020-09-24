@extends('layouts.backend')

@section('meta')
    <title>{{ __('Profile') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@php
    $user = Auth::user();
    $unverified = $user instanceof Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail();
@endphp

@section('content')
    @if ($unverified)
        <form action="{{ route('verification.resend') }}" id="resend-form" method="post" style="display: none;">
            @csrf
        </form>
        <script>
            function resend(e) {
                e.preventDefault();
                document.forms['resend-form'].submit()
            }
        </script>
    @endif
    @if (session('resent'))
        <div class="container">
            <div class="alert alert-success" role="alert">
                {{ __('We have resent the verification link to your email address.') }}
            </div>
        </div>
    @endif
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
            </ol>
        </nav>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Profile') }}</h5>
                <p class="card-text">{{ __('Review and update your personal information.') }}</p>
            </div>
            <div class="card-body border-top">
                @php
                @endphp
                <div class="row">
                    <div class="col-lg-10 col-xl-8">
                        <form action="" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="profile-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
                                <div class="col-sm-8">
                                    <input autofocus class="form-control @error('name') is-invalid @enderror" id="profile-name" name="name" required value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="profile-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
                                <div class="col-sm-8">
                                    <input class="form-control @error('email') is-invalid @enderror" id="profile-email" name="email" required type="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($unverified)
                                        <small class="form-text text-muted">
                                            <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                                            {{ __('Please check your email for a verification link to verify your email address.') }}
                                            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" onclick="resend(event)">{{ __('click here to request another one') }}</a>.
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="profile-password">{{ __('Current password') }}</label>
                                <div class="col-sm-8">
                                    <input class="form-control @error('password') is-invalid @enderror" id="profile-password" name="password" type="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="profile-new-password">{{ __('New password') }}</label>
                                <div class="col-sm-8">
                                    <input class="form-control @error('new_password') is-invalid @enderror" id="profile-new-password" name="new_password" type="password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="profile-new-password-confirmation">{{ __('Confirm password') }}</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="profile-new-password-confirmation" name="new_password_confirmation" type="password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check mr-1"></i> {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
