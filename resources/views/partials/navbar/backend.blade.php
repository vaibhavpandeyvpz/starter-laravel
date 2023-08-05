<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav me-auto">
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
