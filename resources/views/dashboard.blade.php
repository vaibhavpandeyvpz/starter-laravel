@extends('layouts.backend')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Dashboard') }}</h5>
                        <p class="card-text">
                            {{ __('Hey :name, you are now logged in!', ['name' => strtolower(Auth::user()->name)]) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
