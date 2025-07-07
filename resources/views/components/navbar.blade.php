<nav class="navbar navbar-expand-lg" role="navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src={{ asset('images/logo.png') }} width="160" height="90" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach ($navbar_links as $navbar_item)
                    <li class="nav-item">
                        @if ($navbar_item->external)
                            <a class="nav-link" href="{{ $navbar_item->link }}" target="_blank">
                                <img src={{ asset('images/icons/popout.svg') }} />
                                {{ $navbar_item->label }}
                            </a>
                        @elseif ($navbar_item->disabled)
                            <a class="nav-link disabled" href="{{ $navbar_item->link }}">
                                {{ $navbar_item->label }}
                            </a>
                        @elseif ($navbar_item->external && $navbar_item->disabled)
                            <a class="nav-link disabled" href="{{ $navbar_item->link }}" target="_blank">
                                <img src={{ asset('images/icons/popout.svg') }} />
                                {{ $navbar_item->label }}
                            </a>
                        @else
                            <a class="nav-link" href="{{ $navbar_item->link }}">
                                {{ $navbar_item->label }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="/storage/{{Auth::user()->avatar}}" height="32" width="32" />
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile"><img src={{ asset('images/icons/profile.svg') }} /> Profile</a></li>
                            <li><a class="dropdown-item" href="/settings/account"><img src={{ asset('images/icons/settings.svg') }} /> Settings</a></li>
                            <li>
                                <form method="post" action="/auth/logout">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                            <li>
                                <form method="post" action="auth/delete">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Delete Account</button>
                                </form>
                        </ul>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
