@extends('layouts.backend')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.delete-confirmation', [
        'id' => 'delete-confirmation-'.$user->getKey(),
        'action' => route('users.destroy', $user),
        'message' => __('Do you really want to delete this user?'),
    ])
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('Details') }}</h5>
            <p class="card-text">{{ __('See information about existing user here.') }}</p>
            <div class="btn-toolbar">
                <a class="btn btn-info ms-1" href="{{ route('users.edit', $user) }}">
                    <i class="fa-solid fa-feather"></i> <span class="d-none d-sm-inline ms-1">{{ __('Edit') }}</span>
                </a>
                <button class="btn btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $user->getKey() }}">
                    <i class="fa-solid fa-trash"></i> <span class="d-none d-sm-inline ms-1">{{ __('Delete') }}</span>
                </button>
            </div>
        </div>
        <div class="table-responsive border-top">
            <table class="table mb-0">
                <tbody>
                <tr>
                    <th class="bg-light">{{ __('Photo') }}</th>
                    <td class="w-100">
                        @if ($user->photo)
                            <img alt="{{ $user->name }}" class="rounded" height="24" src="{{ $user->photo_url }}">
                        @else
                            @include('partials.photo-placeholder', ['width' => 24, 'height' => 24])
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">{{ __('Name') }}</th>
                    <td class="w-100">{{ $user->name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">{{ __('Email address') }}</th>
                    <td class="w-100">{{ $user->email }}</td>
                </tr>
                <tr>
                    <th class="bg-light">{{ __('Date of birth') }}</th>
                    <td class="w-100">
                        @if ($user->birthday)
                            {{ $user->birthday->format('d/m/Y') }} <span class="text-muted">({{ __(':count years', ['count' => $user->birthday->diffInYears()]) }})</span>
                        @else
                            <span class="text-muted">{{ __('Empty') }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">{{ __('Enabled?') }}</th>
                    <td class="w-100">
                        @if ($user->enabled)
                            <span class="text-success">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Yes') }}
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fa-solid fa-times me-1"></i> {{ __('No') }}
                            </span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer border-top-0">
            <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($user->created_at) }}
            <span class="d-none d-md-inline">
                &bull; <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($user->updated_at) }}
            </span>
        </div>
    </div>
@endsection
