@extends('layouts.backend')

@section('meta')
    <title>{{ __('Users') }} - {{ $user->name }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ config('app.name') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('backend.users.index') }}">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-3">
            <a class="btn btn-outline-dark" href="{{ route('backend.users.index') }}">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Users') }}
            </a>
            <a class="btn btn-info ml-auto" href="{{ route('backend.users.edit', $user) }}">
                <i class="fas fa-feather mr-1"></i> {{ __('Edit') }}
            </a>
            @can('administer')
                <button class="btn btn-danger ml-1" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation">
                    <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                </button>
            @endcan
        </div>
        <div id="delete-confirmation" style="display: none">
            <p>{{ __('This action cannot be undone. Are you sure?') }}</p>
            <form action="{{ route('backend.users.destroy', $user) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="btn-toolbar">
                    <button class="btn btn-danger btn-sm ml-auto"><i class="fas fa-trash mr-1"></i> {{ __('Delete') }}</button>
                    <button class="btn btn-outline-dark btn-sm ml-1 mr-auto" data-dismiss="popover" type="button">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ __('Details') }}</h5>
                <p class="card-text">{{ __('See information about existing user here.') }}</p>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                    <tr>
                        <th class="bg-light">{{ __('Name') }}</th>
                        <td class="w-100">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">{{ __('Email address') }}</th>
                        <td class="w-100"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    </tr>
                    <tr>
                        <th class="bg-light">{{ __('Password') }}</th>
                        <td class="w-100 text-muted">&ast;&ast;&ast;&ast;&ast;</td>
                    </tr>
                    <tr>
                        <th class="bg-light">{{ __('Role') }}</th>
                        <td class="w-100">
                            @if ($user->role)
                                {{ config('fixtures.roles.' . $user->role) }}
                            @else
                                <span class="text-muted">{{ __('None') }}</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <span class="text-muted">{{ __('Created at') }}</span> {{ $user->created_at->format('d/m/Y H:i') }}
                <span class="d-none d-md-inline">
                    &bull;
                    <span class="text-muted">{{ __('Updated at') }}</span> {{ $user->updated_at->format('d/m/Y H:i') }}
                </span>
            </div>
        </div>
    </main>
@endsection