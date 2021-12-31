<div class="card shadow-sm">
    <div class="card-body">
        <div class="spinner-border spinner-border-sm float-right" role="status" wire:loading>
            <span class="sr-only">{{ __('Loading') }}&hellip;</span>
        </div>
        <h5 class="card-title text-primary">{{ __('Roles') }}</h5>
        <p class="card-text">
            {{ __('List and manage user roles here.') }}
            <a href="" wire:click.prevent="filter()">
                {{ __($filtering ? 'Hide filters?' : 'Show filters?') }}
            </a>
        </p>
    </div>
    @if ($filtering)
        <div class="card-body border-top">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group mb-md-0">
                        <label for="filter-search">{{ __('Search') }}</label>
                        <input id="filter-search" class="form-control" placeholder="{{ __('Enter name') }}&hellip;" wire:model.debounce.500ms="search">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group mb-md-0">
                        <label for="filter-permission">{{ __('Permission') }}</label>
                        <select id="filter-permission" class="custom-select" wire:model="permission">
                            <option value="">{{ __('Select') }}&hellip;</option>
                            @foreach (Spatie\Permission\Models\Permission::query()->get() as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 offset-lg-3">
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
                <th>{{ __('Permissions') }}</th>
                <th>{{ __('Users') }}</th>
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
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td><a href="{{ route('backend.roles.show', $role) }}">{{ $role->name }}</a></td>
                    <td>{{ __(':count Permissions', ['count' => $role->permissions()->count()]) }}</td>
                    <td>{{ __(':count Users', ['count' => $role->users()->count()]) }}</td>
                    <td>{{ Timezone::convertToLocal($role->created_at) }}</td>
                    <td>
                        @can('view', $role)
                            <a class="btn btn-outline-dark btn-sm" href="{{ route('backend.roles.show', $role) }}">
                                <i class="fas fa-eye mr-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $role)
                            <a class="btn btn-info btn-sm" href="{{ route('backend.roles.edit', $role) }}">
                                <i class="fas fa-feather mr-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $role)
                            <button class="btn btn-danger btn-sm" data-toggle="popover" data-title="{{ __('Delete') }}" data-target="#delete-confirmation-{{ $role->id }}">
                                <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                            </button>
                            <div id="delete-confirmation-{{ $role->id }}" style="display: none;">
                                <p>{{ __('This action cannot be undone. Are you sure?') }}</p>
                                <form action="{{ route('backend.roles.destroy', $role) }}" method="post">
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
                    <td class="text-center text-muted" colspan="6">{{ __('Could not find any roles to show.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($roles->hasPages())
        <div class="card-body border-top">
            {{ $roles->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top">
        {{ __('Showing :from to :to of :total roles.', ['from' => $roles->firstItem() ?: 0, 'to' => $roles->lastItem() ?: 0, 'total' => $roles->total()]) }}
    </div>
</div>
