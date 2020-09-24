@extends('layouts.backend')

@section('meta')
    <title>{{ __('Users') }} &raquo; {{ $user->name }} &raquo; {{ __('Edit') }} - {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.users.index') }}">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.users.show', $user) }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-3">
            <a class="btn btn-outline-dark" href="{{ route('backend.users.show', $user) }}">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Details') }}
            </a>
        </div>
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
                            @method('PUT')
                            @include('backend.users.form')
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <div class="btn-toolbar">
                                        <button class="btn btn-success">
                                            <i class="fas fa-check mr-1"></i> {{ __('Save') }}
                                        </button>
                                        <a class="btn btn-outline-dark ml-1" href="{{ route('backend.users.show', $user) }}">
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
    </main>
@endsection
