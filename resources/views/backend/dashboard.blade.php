@extends('layouts.backend')

@section('meta')
    <title>{{ __('Dashboard') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@php
    /** @var App\User $user */
    $user = Auth::user();
    $unverified = $user instanceof Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail();
@endphp

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ __('Backend') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
        </ol>
    </nav>
@endsection

@section('alerts')
    @if ($unverified)
        <div class="alert alert-warning alert-important" role="alert">
            {{ __('Please check your email for a verification link to verify your email address.') }}
            {{ __('If you did not receive the email') }}, <a class="alert-link" href="{{ route('verification.resend') }}" onclick="resend(event)">{{ __('click here to request another one') }}</a>.
        </div>
    @endif
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('We have resent the verification link to your email address.') }}
        </div>
    @endif
    @parent
@endsection

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
    <main class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Dashboard') }}</h5>
                <p class="card-text">{{ Illuminate\Foundation\Inspiring::quote() }}</p>
            </div>
        </div>
    </main>
@endsection
