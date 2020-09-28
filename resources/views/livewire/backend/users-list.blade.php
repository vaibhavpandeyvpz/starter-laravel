<div class="card shadow-sm">
    <div class="card-body">
        <div class="spinner-border spinner-border-sm float-right" role="status" wire:loading>
            <span class="sr-only">{{ __('Loading') }}&hellip;</span>
        </div>
        <h5 class="card-title text-primary">{{ __('Users') }}</h5>
        <p class="card-text">{{ __('List and manage registered users here.') }}</p>
    </div>
    <div class="card-body border-top">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="form-group mb-sm-0">
                    <label for="filter-search">{{ __('Search') }}</label>
                    <input id="filter-search" class="form-control" placeholder="{{ __('Enter name or email') }}&hellip;" wire:model.debounce.500ms="q" value="{{ $q }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 offset-md-4 offset-lg-6">
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
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
            <tr>
                <th>#</th>
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
                <th>{{ __('Role') }}</th>
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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role)
                            {{ config('fixtures.roles.' . $user->role) }}
                        @else
                            <span class="text-muted">{{ __('None') }}</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('backend.users.show', $user) }}">
                            <i class="fas fa-eye mr-1"></i> {{ __('Details') }}
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('backend.users.edit', $user) }}">
                            <i class="fas fa-feather mr-1"></i> {{ __('Edit') }}
                        </a>
                        @can('administer')
                            <button class="btn btn-danger btn-sm" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation-{{ $user->id }}">
                                <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                            </button>
                            <div id="delete-confirmation-{{ $user->id }}" style="display: none;">
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
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="6">{{ __('Could not find any users to show.') }}</td>
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
