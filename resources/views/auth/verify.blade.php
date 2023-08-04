@extends('layouts.auth')

@section('meta')
    <title>{{ __('Email Verification') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Email verification') }}
    </h1>
    @if (session('resent'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ __('New verification link has been sent to the email address you provided during registration.') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif
    <p class="card-text">
        {{ __('Thanks for signing up!') }}
        {{ __('Before getting started, we need you to verify your email address by clicking on the link we just emailed to you.') }}
    </p>
    <p class="card-text">
        {{ __("If you didn't receive the email, we will gladly send you another.") }}
    </p>
    <form action="{{ route('verification.resend') }}" method="post">
        @csrf
        <div class="btn-toolbar justify-content-end">
            <button class="btn btn-secondary btn-lg">
                {{ __('Resend link') }} <i class="fa-solid fa-rotate-right ms-1"></i>
            </button>
        </div>
    </form>
@endsection
