@extends('layouts.backend')

@section('meta')
    <title>{{ __('Roles') }} - {{ $role->name }} - {{ __('Edit') }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ __('Backend') }}</a></li>
            @can('viewAny', App\Role::class)
                <li class="breadcrumb-item"><a href="{{ route('backend.roles.index') }}">{{ __('Roles') }}</a></li>
            @else
                <li class="breadcrumb-item">{{ __('Roles') }}</li>
            @endcan
            @can('view', $role)
                <li class="breadcrumb-item"><a href="{{ route('backend.roles.show', $role) }}">{{ $role->name }}</a></li>
            @else
                <li class="breadcrumb-item">{{ $role->name }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <main class="container">
        @can('view', $role)
            <div class="btn-toolbar mb-3">
                <a class="btn btn-outline-dark" href="{{ route('backend.roles.show', $role) }}">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Details') }}
                </a>
            </div>
        @endcan
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Edit') }}</h5>
                <p class="card-text">{{ __('Update existing role information here.') }}</p>
            </div>
            <div class="card-body border-top">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <form action="{{ route('backend.roles.update', $role) }}" method="post">
                            @csrf
                            @method('put')
                            @include('backend.roles.form')
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <div class="btn-toolbar">
                                        <button class="btn btn-success">
                                            <i class="fas fa-check mr-1"></i> {{ __('Save') }}
                                        </button>
                                        @can('view', $role)
                                            <a class="btn btn-outline-dark ml-1" href="{{ route('backend.roles.show', $role) }}">
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
