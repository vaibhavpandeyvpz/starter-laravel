@extends('layouts.backend')

@section('meta')
    <title>{{ __('Roles') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Roles') }}</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-3">
            <a class="btn btn-success ml-auto" href="{{ route('backend.roles.create') }}">
                <i class="fas fa-plus mr-1"></i> {{ __('New') }}
            </a>
        </div>
        @livewire('backend.roles-list')
    </main>
@endsection