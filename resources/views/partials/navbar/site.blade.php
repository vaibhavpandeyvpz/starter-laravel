<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link @if (Route::is('home')) active @endif" href="{{ route('home') }}">
                        {{ __('Home') }}
                    </a>
                </li>
                @auth
                    <li class="nav-item d-md-none">
                        <a class="nav-link @if (Route::is('dashboard')) active @endif" href="{{ route('dashboard') }}">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                @endauth
            </ul>
            @auth
                <a class="btn btn-outline-primary d-none d-md-inline-block" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> {{ __('Dashboard') }}
                </a>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                </ul>
            @endauth
        </div>
    </div>
</nav>
