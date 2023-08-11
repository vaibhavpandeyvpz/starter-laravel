@extends('layouts.backend')

@section('meta')
    <title>{{ __('Edit') }} | {{ $role->name }} | {{ __('Roles') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\Role::class)
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ __('Roles') }}</li>
            @endcan
            @can('update', $role)
                <li class="breadcrumb-item"><a href="{{ route('roles.show', $role) }}">{{ $role->name }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $role->name }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Edit') }}</h5>
            <p class="card-text">{{ __('Update existing role details.') }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('roles.update', $role) }}" method="post">
                        @csrf
                        @method('put')
                        @lockInput($role)
                        @include('roles.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    @can('view', $role)
                                        <a class="btn btn-outline-dark ms-1" href="{{ route('roles.show', $role) }}">
                                            {{ __('Cancel') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
