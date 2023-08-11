@extends('layouts.backend')

@section('meta')
    <title>{{ __('Edit') }} | {{ $user->name }} | {{ __('Users') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\User::class)
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            @else
                <li class="breadcrumb-item">{{ __('Users')  }}</li>
            @endcan
            @can('update', $user)
                <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Edit') }}</h5>
            <p class="card-text">{{ __('Update existing user details.') }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('users.update', $user) }}" method="post">
                        @csrf
                        @method('put')
                        @lockInput($user)
                        @include('users.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    @can('view', $user)
                                        <a class="btn btn-outline-dark ms-1" href="{{ route('users.show', $user) }}">
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
