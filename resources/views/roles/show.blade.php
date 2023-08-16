@extends('layouts.backend')

@section('meta')
    <title>{{ $role->name }} | {{ __('Roles') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\Role::class)
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ __('Roles') }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.delete-confirmation', [
        'id' => 'delete-confirmation-'.$role->getKey(),
        'action' => route('roles.destroy', $role),
        'message' => __('Do you really want to delete this role?'),
    ])
    <div class="row">
        <div class="col-lg-8 col-xl-9">
            <div class="card border-0 shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Details') }}</h5>
                    <p class="card-text">{{ __('See information about existing role here.') }}</p>
                    @if (Gate::allows('update', $role) || Gate::allows('delete', $role))
                        <div class="btn-toolbar">
                            @can('update', $role)
                                <a class="btn btn-info me-1" href="{{ route('roles.edit', $role) }}">
                                    <i class="fa-solid fa-feather"></i> <span class="d-none d-sm-inline ms-1">{{ __('Edit') }}</span>
                                </a>
                            @endcan
                            @can('delete', $role)
                                <button class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $role->getKey() }}">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-sm-inline ms-1">{{ __('Delete') }}</span>
                                </button>
                            @endcan
                        </div>
                    @endif
                </div>
                <div class="table-responsive border-top">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <th class="bg-light">{{ __('Name') }}</th>
                            <td class="w-100">{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light align-text-top">{{ __('Permissions') }}</th>
                            <td class="w-100 text-wrap">
                                @forelse ($role->permissions as $permission)
                                    <span class="badge bg-dark me-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">{{ __('None') }}</span>
                                @endforelse
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Users') }}</th>
                            <td class="w-100">
                                @php
                                    $count = $role->users()->count();
                                @endphp
                                {{ __(':count users', compact('count')) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-top-0">
                    <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($role->created_at) }}
                    <span class="d-none d-md-inline">
                        &bull; <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($role->updated_at) }}
                    </span>
                </div>
            </div>
            <div class="mb-3 mb-lg-0">
                <livewire:activity-log-list :model="$role" />
            </div>
        </div>
        <div class="col-lg-4 col-xl-3">
            @include('partials.auditors', ['model' => $role])
        </div>
    </div>
@endsection
