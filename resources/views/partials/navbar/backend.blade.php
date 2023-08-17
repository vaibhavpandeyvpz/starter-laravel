<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav me-auto me-lg-3">
                <li class="nav-item">
                    <a class="nav-link @if (Route::is('dashboard')) active @endif" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @can('viewAny', App\Models\User::class)
                    <li class="nav-item">
                        <a class="nav-link @if (Route::is('users.*')) active @endif" href="{{ route('users.index') }}">
                            {{ __('Users') }}
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Role::class)
                    <li class="nav-item">
                        <a class="nav-link @if (Route::is('roles.*')) active @endif" href="{{ route('roles.index') }}">
                            {{ __('Roles') }}
                        </a>
                    </li>
                @endcan
                <li class="nav-item d-md-none">
                    <a class="nav-link @if (Route::is('profile')) active @endif" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); logout()">{{ __('Logout') }}</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('home') }}">
                        {{ __('Site') }} <i class="fa-solid fa-arrow-right-to-bracket ms-1"></i>
                    </a>
                </li>
            </ul>
            <div class="d-none d-lg-flex me-auto" role="search">
                <div id="search-navbar" aria-label="{{ __('Search') }}"></div>
            </div>
            <ul class="navbar-nav d-none d-md-inline-block me-md-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="dropdown-account" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-account">
                        <li>
                            <a class="dropdown-item @if (Route::is('profile')) active @endif" href="{{ route('profile') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); logout()">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-outline-primary d-none d-md-inline-block" href="{{ route('home') }}">
                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> {{ __('Site') }}
            </a>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#search-navbar').search({
                source: '{{ route('dashboard.search') }}',
                placeholder: '{{ __('Type name or email...') }}',
                item({ item, components, html }) {
                    return html`
                    <div class="d-flex flex-row gap-2 align-top">
                        ${item.photo ? (
                        html`<img alt="${item.name}" src="${item.photo}" width="32" height="32">`
                    ) : (
                        html`<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <rect width="100%" height="100%" fill="#eeeeee"></rect>
                            </svg>`
                    )}
                        <div class="d-flex flex-column gap-1">
                            <div class="aa-ItemContentTitle">
                                ${components.Highlight({ hit: item, attribute: 'name' })}
                            </div>
                            <div class="aa-ItemContentDescription">
                                ${components.Snippet({ hit: item, attribute: 'email' })}
                            </div>
                        </div>
                    </div>`;
                },
            }).on('change', function (e, user) {
                location.href = route('users.show', user.id);
            });
        });
    </script>
@endpush
