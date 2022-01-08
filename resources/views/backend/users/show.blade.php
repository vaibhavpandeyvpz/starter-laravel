@extends('layouts.backend')

@section('meta')
    <title>{{ __('Users') }} - {{ $user->name }} | {{ __('Backend') }} | {{ config('app.name') }}</title>
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
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <main class="container">
        <div class="btn-toolbar mb-3">
            @can('viewAny', App\User::class)
                <a class="btn btn-outline-dark mr-1" href="{{ route('backend.users.index') }}">
                    <i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline ml-1">{{ __('Users') }}</span>
                </a>
            @endcan
            <div class="mx-auto"></div>
            @can('update', $user)
                <a class="btn btn-info ml-1" href="{{ route('backend.users.edit', $user) }}">
                    <i class="fas fa-feather"></i> <span class="d-none d-sm-inline ml-1">{{ __('Edit') }}</span>
                </a>
            @endcan
            @can('delete', $user)
                <button class="btn btn-danger ml-1" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation">
                    <i class="fas fa-trash"></i> <span class="d-none d-sm-inline ml-1">{{ __('Delete') }}</span>
                </button>
            @endcan
        </div>
        <div id="delete-confirmation" style="display: none;">
            <p>{{ __('This action cannot be undone. Are you sure?') }}</p>
            <form action="{{ route('backend.users.destroy', $user) }}" method="post">
                @csrf
                @method('delete')
                <div class="btn-toolbar">
                    <button class="btn btn-danger btn-sm ml-auto"><i class="fas fa-trash mr-1"></i> {{ __('Delete') }}</button>
                    <button class="btn btn-outline-dark btn-sm ml-1 mr-auto" data-dismiss="popover" type="button">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ __('Details') }}</h5>
                        <p class="card-text">{{ __('See information about existing user here.') }}</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                            <tr>
                                <th class="bg-light align-middle">{{ __('Photo') }}</th>
                                <td class="w-100">
                                    @if ($user->photo)
                                        <img alt="{{ $user->name }}" class="rounded" height="32" src="{{ $user->photo_url }}">
                                    @else
                                        @include('partials.placeholder', [
                                            'class' => 'rounded',
                                            'width' => 32,
                                            'height' => 32,
                                        ])
                                    @endif
                                </td>
                            </tr>
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
                            @can('viewAny', App\Role::class)
                                <tr>
                                    <th class="bg-light">{{ __('Roles') }}</th>
                                    <td class="w-100">
                                        @forelse ($user->roles()->get() as $role)
                                            <span class="badge badge-dark mr-1">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">{{ __('None') }}</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @endcan
                            <tr>
                                <th class="bg-light">{{ __('Enabled?') }}</th>
                                <td class="w-100">
                                    @if ($user->enabled)
                                        <i class="fas fa-toggle-on text-primary mr-1"></i>
                                    @else
                                        <i class="fas fa-toggle-off text-muted mr-1"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">{{ __('Birthday') }}</th>
                                <td class="w-100">
                                    @if ($user->birthday)
                                        {{ $user->birthday->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">{{ __('Not set') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">{{ __('Timezone') }}</th>
                                <td class="w-100">{{ $user->timezone }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($user->created_at) }}
                        <span class="d-none d-md-inline">
                            &bull;
                            <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($user->updated_at) }}
                        </span>
                    </div>
                </div>
                <div class="mb-3 mb-md-0">
                    @livewire('backend.activity-logs-list', ['model' => $user])
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                @include('partials.auditors', ['model' => $user])
            </div>
        </div>
    </main>
@endsection
