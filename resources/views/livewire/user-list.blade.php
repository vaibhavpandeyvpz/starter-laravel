<div class="card border-0 shadow" x-data="{ filtering: $persist(false).as('user-list-filtering') }">
    <div class="card-body border-bottom">
        <div class="d-flex align-items-center float-end">
            <div class="spinner-border spinner-border-sm float-end" role="status" wire:loading>
                <span class="visually-hidden">{{ __('Loading') }}&hellip;</span>
            </div>
            @can('create', App\Models\User::class)
                <a class="btn btn-success ms-3" href="{{ route('users.create') }}">
                    <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline ms-1">{{ __('New') }}</span>
                </a>
            @endcan
        </div>
        <h5 class="card-title">{{ __('Users') }}</h5>
        <p class="card-text" :class="{ 'mb-0': ! filtering }">
            {{ __('List and manage users here.') }}
            <a href="" @click.prevent="filtering = ! filtering">
                <span x-show="filtering">{{ __('Hide filters?') }}</span>
                <span x-show="! filtering">{{ __('Show filters?') }}</span>
            </a>
        </p>
        <div class="row" x-show="filtering" x-transition>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="mb-3">
                    <label class="form-label" for="filter-search">{{ __('Search') }}</label>
                    <input class="form-control" id="filter-search" placeholder="{{ __('Enter name or email') }}&hellip;" wire:model.debounce.500ms="q" value="{{ $q }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3">
                    <label class="form-label" for="filter-role">{{ __('Role') }}</label>
                    <select class="form-select" data-widget="dropdown" id="filter-role">
                        <option value="">{{ __('Any') }}</option>
                        <option value="0">{{ __('None') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->getKey() }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3">
                    <label class="form-label" for="filter-enabled">{{ __('Enabled?') }}</label>
                    <select class="form-select" data-widget="dropdown" id="filter-enabled">
                        <option value="">{{ __('Any') }}</option>
                        <option value="1">{{ __('Yes') }}</option>
                        <option value="0">{{ __('No') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3 mb-md-0">
                    <label class="form-label" for="filter-from-date">{{ __('Created from') }}</label>
                    <input class="form-control" data-widget="datepicker" id="filter-from-date" value="{{ $fromDate }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3 mb-sm-0">
                    <label class="form-label" for="filter-to-date">{{ __('Created up to') }}</label>
                    <input class="form-control" data-widget="datepicker" id="filter-to-date" value="{{ $toDate }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
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
                <th class="bg-light"></th>
                <th class="bg-light">
                    @if (($order['name'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'desc')">{{ __('Name') }}</a>
                        <i class="fa-solid fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['name'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', false)">{{ __('Name') }}</a>
                        <i class="fa-solid fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'asc')">{{ __('Name') }}</a>
                    @endif
                </th>
                <th class="bg-light">{{ __('Email address') }}</th>
                <th class="bg-light">{{ __('Birthday') }}</th>
                <th class="bg-light">{{ __('Enabled?') }}</th>
                <th class="bg-light">
                    @if (($order['created_at'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'desc')">{{ __('Created at') }}</a>
                        <i class="fa-solid fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['created_at'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', false)">{{ __('Created at') }}</a>
                        <i class="fa-solid fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'asc')">{{ __('Created at') }}</a>
                    @endif
                </th>
                <th class="bg-light"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->getKey() }}</td>
                    <td>
                        @if ($user->photo)
                            <img alt="{{ $user->name }}" height="24" src="{{ $user->photo_url }}">
                        @else
                            @include('partials.placeholder-image', ['width' => 24, 'height' => 24])
                        @endif
                    </td>
                    <td>
                        @can('view', $user)
                            <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                        @else
                            {{ $user->name }}
                        @endcan
                    </td>
                    <td>
                        <a href="mailto:{{ $user->email }}">
                            {{ $user->email }}
                        </a>
                    </td>
                    <td>
                        @if ($user->birthday)
                            {{ $user->birthday->format('d/m/Y') }} <span class="text-muted">({{ __(':count years', ['count' => $user->birthday->diffInYears()]) }})</span>
                        @else
                            <span class="text-muted">{{ __('Empty') }}</span>
                        @endif
                    </td>
                    <td>
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
                    <td>{{ Timezone::convertToLocal($user->created_at) }}</td>
                    <td>
                        @can('view', $user)
                            <a class="btn btn-link text-decoration-none btn-sm" href="{{ route('users.show', $user) }}">
                                <i class="fa-solid fa-eye me-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $user)
                            <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user) }}">
                                <i class="fa-solid fa-pen me-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $user)
                            <button class="btn btn-danger btn-sm" data-bs-title="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $user->getKey() }}">
                                <i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}
                            </button>
                            @include('partials.delete-confirmation', [
                                'id' => 'delete-confirmation-'.$user->getKey(),
                                'action' => route('users.destroy', $user),
                                'message' => __('Do you really want to delete this user?'),
                            ])
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="7">
                        {{ __('Could not find any users to show.') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="card-body">
            {{ $users->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top-0">
        {{ __('Showing :from to :to of :total users.', ['from' => $users->firstItem() ?: 0, 'to' => $users->lastItem() ?: 0, 'total' => $users->total()]) }}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#filter-role').on('select2:select', function (e) {
                @this.role = e.params.data.id;
            });

            $('#filter-enabled').on('select2:select', function (e) {
                @this.enabled = e.params.data.id;
            });

            $('#filter-length').on('select2:select', function (e) {
                @this.length = e.params.data.id;
            });

            $('#filter-from-date').on('change', function (e) {
                @this.fromDate = e.target.value;
            });

            $('#filter-to-date').on('change', function (e) {
                @this.toDate = e.target.value;
            });
        });
    </script>
@endpush
