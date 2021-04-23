@extends('layouts.backend')

@section('meta')
    <title>{{ __('Users') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-3">
            <a class="btn btn-success ml-auto" href="{{ route('backend.users.create') }}">
                <i class="fas fa-plus"></i> <span class="d-none d-sm-none ml-1">{{ __('New') }}</span>
            </a>
        </div>
        @livewire('backend.users-list')
    </main>
@endsection
