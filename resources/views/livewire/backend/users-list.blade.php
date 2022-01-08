<div class="card shadow-sm">
    <div class="card-body">
        <div class="spinner-border spinner-border-sm float-right" role="status" wire:loading>
            <span class="sr-only">{{ __('Loading') }}&hellip;</span>
        </div>
        <h5 class="card-title text-primary">{{ __('Users') }}</h5>
        <p class="card-text">
            {{ __('List and manage registered users here.') }}
            <a href="" wire:click.prevent="filter()">
                {{ __($filtering ? 'Hide filters?' : 'Show filters?') }}
            </a>
        </p>
    </div>
    @if ($filtering)
        <div class="card-body border-top">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group @can('viewAny', App\Role::class) mb-lg-0 @else mb-md-0 @endif">
                        <label for="filter-search">{{ __('Search') }}</label>
                        <input id="filter-search" class="form-control" placeholder="{{ __('Enter name or email') }}&hellip;" wire:model.debounce.500ms="search">
                    </div>
                </div>
                @can('viewAny', App\Role::class)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group mb-md-0">
                            <label for="filter-role">{{ __('Role') }}</label>
                            <select id="filter-role" class="custom-select" wire:model="role">
                                <option value="">{{ __('Select') }}&hellip;</option>
                                @foreach (App\Role::query()->get() as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group mb-sm-0">
                        <label for="filter-enabled">{{ __('Enabled?') }}</label>
                        <select id="filter-enabled" class="custom-select" wire:model="enabled">
                            <option value="">{{ __('Select') }}&hellip;</option>
                            <option value="true">{{ __('Yes') }}</option>
                            <option value="false">{{ __('No') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group mb-0">
                        <label for="filter-length">{{ __('Length') }}</label>
                        <select id="filter-length" class="form-control" wire:model="length">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th></th>
                <th>
                    @if (($order['name'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'desc')">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down-alt ml-1"></i>
                    @elseif (($order['name'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', false)">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down ml-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'asc')">{{ __('Name') }}</a>
                    @endif
                </th>
                <th>
                    @if (($order['email'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('email', 'desc')">{{ __('Email address') }}</a>
                        <i class="fas fa-sort-amount-down-alt ml-1"></i>
                    @elseif (($order['email'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('email', false)">{{ __('Email address') }}</a>
                        <i class="fas fa-sort-amount-down ml-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('email', 'asc')">{{ __('Email address') }}</a>
                    @endif
                </th>
                @can('viewAny', App\Role::class)
                    <th>{{ __('Roles') }}</th>
                @endcan
                <th>
                    @if (($order['created_at'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'desc')">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down-alt ml-1"></i>
                    @elseif (($order['created_at'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', false)">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down ml-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'asc')">{{ __('Created at') }}</a>
                    @endif
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
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
                    <td><a href="{{ route('backend.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    @can('viewAny', App\Role::class)
                        <td>{{ __(':count Roles', ['count' => $user->roles()->count()]) }}</td>
                    @endcan
                    <td>{{ Timezone::convertToLocal($user->created_at) }}</td>
                    <td>
                        @can('view', $user)
                            <a class="btn btn-outline-dark btn-sm" href="{{ route('backend.users.show', $user) }}">
                                <i class="fas fa-eye mr-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $user)
                            <a class="btn btn-info btn-sm" href="{{ route('backend.users.edit', $user) }}">
                                <i class="fas fa-feather mr-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $user)
                            <button class="btn btn-danger btn-sm" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation-{{ $user->id }}">
                                <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                            </button>
                            <div id="delete-confirmation-{{ $user->id }}" style="display: none;">
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
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="@can('viewAny', App\Role::class) 7 @else 6 @endif">{{ __('Could not find any users to show.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="card-body border-top">
            {{ $users->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top">
        {{ __('Showing :from to :to of :total users.', ['from' => $users->firstItem() ?: 0, 'to' => $users->lastItem() ?: 0, 'total' => $users->total()]) }}
    </div>
</div>
