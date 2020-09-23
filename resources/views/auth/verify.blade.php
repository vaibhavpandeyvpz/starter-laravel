@extends('layouts.auth')

@section('meta')
    <title>{{ __('Verification') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <form action="{{ route('verification.resend') }}" name="form-resend" method="post" style="display: none;">
        @csrf
    </form>
    <script>
        function resend(e) {
            e.preventDefault();
            document.forms['form-resend'].submit()
        }
    </script>
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('We have sent you a fresh verification link.') }}
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Verification') }}</h5>
            <p class="card-text">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p class="card-text">{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" onclick="resend(event)">{{ __('click here to request another') }}</a>.</p>
        </div>
    </div>
@endsection
