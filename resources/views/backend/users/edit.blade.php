@extends('layouts.backend')

@section('meta')
    <title>{{ __('Users') }} - {{ $user->name }} - {{ __('Edit') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ __('Backend') }}</a></li>
            @can('viewAny', App\User::class)
                <li class="breadcrumb-item"><a href="{{ route('backend.users.index') }}">{{ __('Users') }}</a></li>
            @else
                <li class="breadcrumb-item">{{ __('Users') }}</li>
            @endcan
            @can('view', $user)
                <li class="breadcrumb-item"><a href="{{ route('backend.users.show', $user) }}">{{ $user->name }}</a></li>
            @else
                <li class="breadcrumb-item">{{ $user->name }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <main class="container">
        @can('view', $user)
            <div class="btn-toolbar mb-3">
                <a class="btn btn-outline-dark" href="{{ route('backend.users.show', $user) }}">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Details') }}
                </a>
            </div>
        @endcan
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Edit') }}</h5>
                <p class="card-text">{{ __('Update existing user information here.') }}</p>
            </div>
            <div class="card-body border-top">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <form action="{{ route('backend.users.update', $user) }}" method="post">
                            @csrf
                            @method('put')
                            @include('backend.users.form')
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <div class="btn-toolbar">
                                        <button class="btn btn-success">
                                            <i class="fas fa-check mr-1"></i> {{ __('Save') }}
                                        </button>
                                        @can('view', $user)
                                            <a class="btn btn-outline-dark ml-1" href="{{ route('backend.users.show', $user) }}">
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
    </main>
@endsection
