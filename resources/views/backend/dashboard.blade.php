@extends('layouts.backend')

@section('meta')
    <title>{{ __('Dashboard') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
            </ol>
        </nav>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Dashboard') }}</h5>
                <p class="card-text">{{ __('Looks like you are logged in. Is it?') }}</p>
            </div>
        </div>
    </main>
@endsection
