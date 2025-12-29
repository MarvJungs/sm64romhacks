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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('newspost.index') }}">
                        News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('hack.index') }}">
                        ROM Hacks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('megapack.index') }}">
                        Megapack
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Events
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($events as $event)
                            <li>
                                @if ($event->external)
                                    <a class="dropdown-item" href="{{ $event->external_url }}" target="_blank">
                                        <x-bi-box-arrow-up-right />
                                        {{ $event->name }}
                                    </a>
                                @else
                                    <a class="dropdown-item"
                                        href="{{ route('event.show', ['event' => $event]) }}">{{ $event->name }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Gameplay Tools
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('cheats.index') }}">
                                Cheat Codes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('tools.hacktice') }}" target="_blank">
                                <x-bi-box-arrow-up-right />
                                Hacktice
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('tools.emulator') }}" target="_blank">
                                <x-bi-box-arrow-up-right />
                                Luna's Project64
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('tools.patcher') }}">
                                Online Patcher
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('tools.stardisplay') }}" target="_blank">
                                <x-bi-box-arrow-up-right />
                                Stardisplay
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('faq') }}" target="_blank">
                        <x-bi-box-arrow-up-right />
                        FAQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('discord') }}" target="_blank">
                        <x-bi-box-arrow-up-right />
                        Discord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('streams.index') }}">
                        Streams
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('support') }}" target="_blank">
                        <x-bi-box-arrow-up-right />
                        Support!
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                @auth
                    @if (Auth::user()->hasRole('moderator'))
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('modhub.hacks.index') }}"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="ModHub">
                                <x-bi-shield /><span
                                    class="position-absolute translate-middle badge rounded-pill bg-danger">{{ $amountPending }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="/storage/{{ Auth::user()->avatar }}" height="32" width="32" />
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->hasRole('owner'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.index') }}"><x-bi-wrench-adjustable />
                                        Site Management</a>
                                </li>
                            @endif
                            @can('viewAny', App\Models\Romhackevent::class)
                                <li>
                                    <a class="dropdown-item" href="{{ route('events.index') }}"><x-bi-calendar-event-fill />
                                        Events
                                        Management</a>
                                </li>
                            @endcan
                            <li><a class="dropdown-item"
                                    href="{{ route('users.show', ['user' => Auth::user()]) }}"><x-bi-person-fill />
                                    Profile</a></li>
                            <li><a class="dropdown-item" href="/settings/account"><x-bi-person-fill-gear /> Settings</a>
                            </li>
                            <li>
                                <form method="post" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><x-bi-person-fill-down /> Logout</button>
                                </form>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-confirm"
                                    data-bs-route="{{ route('auth.delete') }}" data-bs-action="DELETE"><x-bi-person-fill-slash />
                                    Delete Account</button>
                            </li>
                        </ul>
                    @else
                    <li class="nav-item">
                        <button type="button" class="btn nav-link" data-bs-toggle="modal"
                            data-bs-target="#loginModal">Login</button>
                        @push('modals')
                            <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Choose your Login!</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <a class="btn btn-discord d-block mb-3"
                                                href="{{ route('socialite.redirect', ['driver' => 'discord']) }}"><x-bi-discord />
                                                Login with Discord!</a>
                                            <a class="btn btn-twitch d-block mb-3"
                                                href="{{ route('socialite.redirect', ['driver' => 'twitch']) }}"><x-bi-twitch />
                                                Login with Twitch!</a>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endpush
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
