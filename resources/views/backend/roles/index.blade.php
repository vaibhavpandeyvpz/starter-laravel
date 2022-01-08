@extends('layouts.backend')

@section('meta')
    <title>{{ __('Roles') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ __('Backend') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Roles') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <main class="container">
        @can('create', App\Role::class)
            <div class="btn-toolbar mb-3">
                <a class="btn btn-success ml-auto" href="{{ route('backend.roles.create') }}">
                    <i class="fas fa-plus"></i> <span class="d-none d-sm-inline ml-1">{{ __('New') }}</span>
                </a>
            </div>
        @endcan
        @livewire('backend.roles-list')
    </main>
@endsection
