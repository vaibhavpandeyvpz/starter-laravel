@extends('layouts.backend')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('New')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ __('New') }}</h5>
            <p class="card-text">{{ __('Create a new role account.') }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        @include('roles.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    <a class="btn btn-outline-dark ms-1" href="{{ route('roles.index') }}">
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
