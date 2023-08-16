<div class="card border-0 shadow" x-data="{ filtering: $persist(false).as('role-list-filtering') }">
    <div class="card-body border-bottom">
        <div class="d-flex align-items-center float-end">
            <div class="spinner-border spinner-border-sm float-end" role="status" wire:loading>
                <span class="visually-hidden">{{ __('Loading') }}&hellip;</span>
            </div>
            @can('create', App\Models\Role::class)
                <a class="btn btn-success ms-3" href="{{ route('roles.create') }}">
                    <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline ms-1">{{ __('New') }}</span>
                </a>
            @endcan
        </div>
        <h5 class="card-title">{{ __('Roles') }}</h5>
        <p class="card-text" :class="{ 'mb-0': ! filtering }">
            {{ __('List and manage roles here.') }}
            <a href="" @click.prevent="filtering = ! filtering">
                <span x-show="filtering">{{ __('Hide filters?') }}</span>
                <span x-show="! filtering">{{ __('Show filters?') }}</span>
            </a>
        </p>
        <div class="row" x-show="filtering" x-transition>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="mb-3 mb-md-0">
                    <label class="form-label" for="filter-search">{{ __('Search') }}</label>
                    <input class="form-control" id="filter-search" placeholder="{{ __('Enter name') }}&hellip;" wire:model.debounce.500ms="q" value="{{ $q }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3 mb-md-0">
                    <label class="form-label" for="filter-permission">{{ __('Permission') }}</label>
                    <select class="form-select" data-widget="dropdown" id="filter-permission">
                        <option value="">{{ __('Any') }}</option>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->getKey() }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 offset-xl-3" wire:ignore>
                <label class="form-label" for="filter-length">{{ __('Length') }}</label>
                <select class="form-select" data-widget="dropdown" id="filter-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th class="bg-light">#</th>
                <th class="bg-light">
                    @if (($order['name'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'desc')">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['name'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', false)">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'asc')">{{ __('Name') }}</a>
                    @endif
                </th>
                <th class="bg-light">{{ __('Permissions') }}</th>
                <th class="bg-light">{{ __('Users') }}</th>
                <th class="bg-light">
                    @if (($order['created_at'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'desc')">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['created_at'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', false)">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'asc')">{{ __('Created at') }}</a>
                    @endif
                </th>
                <th class="bg-light"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->getKey() }}</td>
                    <td>
                        @can('view', $role)
                            <a href="{{ route('roles.show', $role) }}">{{ $role->name }}</a>
                        @else
                            {{ $role->name }}
                        @endcan
                    </td>
                    <td>{{ __(':count permissions', ['count' => $role->permissions()->count()]) }}</td>
                    <td>{{ __(':count users', ['count' => $role->users()->count()]) }}</td>
                    <td>{{ Timezone::convertToLocal($role->created_at) }}</td>
                    <td>
                        @can('view', $role)
                            <a class="btn btn-link text-decoration-none btn-sm" href="{{ route('roles.show', $role) }}">
                                <i class="fa-solid fa-eye me-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $role)
                            <a class="btn btn-info btn-sm" href="{{ route('roles.edit', $role) }}">
                                <i class="fa-solid fa-pen me-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $role)
                            <button class="btn btn-danger btn-sm" data-bs-title="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $role->getKey() }}">
                                <i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}
                            </button>
                            @include('partials.delete-confirmation', [
                                'id' => 'delete-confirmation-'.$role->getKey(),
                                'action' => route('roles.destroy', $role),
                                'message' => __('Do you really want to delete this role?'),
                            ])
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="7">
                        {{ __('Could not find any roles to show.') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($roles->hasPages())
        <div class="card-body">
            {{ $roles->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top-0">
        {{ __('Showing :from to :to of :total roles.', ['from' => $roles->firstItem() ?: 0, 'to' => $roles->lastItem() ?: 0, 'total' => $roles->total()]) }}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#filter-permission').on('select2:select', function (e) {
                @this.permission = e.params.data.id;
            });

            $('#filter-length').on('select2:select', function (e) {
                @this.length = e.params.data.id;
            });
        });
    </script>
@endpush
