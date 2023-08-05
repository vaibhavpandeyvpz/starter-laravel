@extends('layouts.backend')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}">{{ $user->name  }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Edit') }}</h5>
            <p class="card-text">{{ __("Update existing user's account.") }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('users.update', $user) }}" method="post">
                        @csrf
                        @method('put')
                        @include('users.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    <a class="btn btn-outline-dark ms-1" href="{{ route('users.show', $user) }}">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
