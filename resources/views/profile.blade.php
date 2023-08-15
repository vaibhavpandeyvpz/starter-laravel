@extends('layouts.backend')

@section('meta')
    <title>{{ __('Profile') }} | {{ config('app.name') }}</title>
@endsection

@php
    $user = Auth::user();
    $unverified = $user instanceof Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail();
@endphp

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
        </ol>
    </nav>
@endsection

@push('flash')
    @if (session('resent'))
        <div class="container">
            <div class="alert alert-success" role="alert">
                {{ __('We have resent the verification link to your email address.') }}
            </div>
        </div>
    @endif
@endpush

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
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Profile') }}</h5>
            <p class="card-text">
                {{ __('Review and update your personal information here.') }}
            </p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-10 col-xl-8">
                    <form action="" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
                            <div class="col-sm-8">
                                <input autofocus class="form-control @error('name') is-invalid @enderror" id="profile-name" name="name" required value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
                            <div class="col-sm-8">
                                <input class="form-control @error('email') is-invalid @enderror" id="profile-email" name="email" required type="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($unverified)
                                    <small class="form-text text-muted">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        {{ __('Please check your email for a verification link to verify your email address.') }}
                                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" onclick="resend(event)">{{ __('click here to request another one') }}</a>.
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-password">{{ __('Current password') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('password') is-invalid @enderror" id="profile-password" name="password" type="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-new-password">{{ __('New password') }}</label>
                            <div class="col-sm-8 col-md-4">
                                <div class="mb-3 mb-md-0">
                                    <input class="form-control @error('new_password') is-invalid @enderror" id="profile-new-password" name="new_password" type="password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('Choose a strong and secure one.') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-4 offset-sm-4 offset-md-0">
                                <!--suppress HtmlFormInputWithoutLabel -->
                                <input class="form-control" id="profile-new-password-confirmation" name="new_password_confirmation" type="password">
                                <small class="form-text text-muted">{{ __('The new password, once more.') }}</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-photo">{{ __('Photo') }}</label>
                            <div class="col-sm-8">
                                <input accept="image/jpeg,image/png" class="form-control @if ($user->photo) mb-3 @endif @error('photo') is-invalid @enderror" name="photo" id="profile-photo" type="file">
                                @error('photo')
                                    <div class="invalid-feedback d-inline-block">{{ $message }}</div>
                                @enderror
                                @if ($user->photo)
                                    <img alt="{{ $user->name }}" height="32" src="{{ $user->photo_url }}">
                                    <div class="form-check mt-sm-2">
                                        <input class="form-check-input @error('photo_remove') is-invalid @enderror" id="profile-photo-remove" type="checkbox" name="photo_remove" value="1" @if (old('photo_remove')) checked @endif>
                                        <label class="form-check-label" for="profile-photo-remove">{{ __('Remove?') }}</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @php
                            $old_birthday = old('birthday', $user->birthday);
                            if ($old_birthday instanceof DateTime) {
                                $old_birthday = $old_birthday->format('Y-m-d');
                            }
                        @endphp
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-birthday">{{ __('Birthday') }}</label>
                            <div class="col-sm-8">
                                <input autocomplete="off" class="form-control @error('birthday') is-invalid @enderror" data-widget="datepicker" id="profile-birthday" name="birthday" value="{{ $old_birthday }}">
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @php
                            $old_timezone = old('timezone', $user->timezone);
                        @endphp
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="profile-timezone">{{ __('Timezone') }} <span class="text-danger">&ast;</span></label>
                            <div class="col-sm-8">
                                <select class="form-control @error('timezone') is-invalid @enderror" data-widget="dropdown" id="profile-timezone" name="timezone" required>
                                    @foreach (timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}" @if ($old_timezone === $timezone) selected @endif>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <button class="btn btn-success">
                                    <i class="fa-solid fa-check me-1"></i> {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
