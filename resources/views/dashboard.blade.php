@extends('layouts.backend')

@section('meta')
    <title>{{ __('Dashboard') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
        </ol>
    </nav>
@endsection

@push('flash')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Dashboard') }}</h5>
            <p class="card-text">
                {{ __('Hey :name, you are now logged in!', ['name' => strtolower(Auth::user()->name)]) }}
                {{ Illuminate\Foundation\Inspiring::quotes()->random() }}
            </p>
        </div>
    </div>
@endsection
