<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    {!! SEOMeta::generate() !!}

    {!! OpenGraph::generate() !!}

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="shortcut icon" href="{{ asset('images/icon.ico') }}" />

</head>

<body>

    <div class="container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="/"><img class="img-responsive d-inline-block align-text-top"
                        src="{{ asset('images/logo.png') }}" alt="Logo" width="160" height="90"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/news">News </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/hacks">ROM Hacks </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/megapack">Megapack</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Events
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($events as $event)
                                    <li><a class="dropdown-item"
                                            href="/events/{{ $event->slug }}">{{ $event->name }}</a>
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
                                <li><a class="dropdown-item" href="/cheats">Cheat Codes</a></li>
                                <li><a class="dropdown-item" href="/stardisplay">Star Display</a></li>
                                <li><a class="dropdown-item" href="/patcher">Online Patcher</a></li>
                                <li><a class="dropdown-item" href="/plugins">Plugin Guide</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/streams">Streams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/discord">Discord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/support">Support!</a>
                        </li>
                        @if (Auth::user())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->getAvatar(['extension' => 'png', 'size' => 256]) }}"
                                        height="32" width="32" />&nbsp;{{ Auth::user()->global_name }} </a>
                                <ul class="dropdown-menu">
                                    @if (Auth::check() && Auth::user()->hasRole(705528172581486704))
                                        <li><a class="dropdown-item" href="/moderation">Moderation</a></li>
                                        <li><a class="dropdown-item" href="/users">Users</a></li>
                                    @endif
                                    <li><a class="dropdown-item"
                                            href="/users/{{ Auth::user()->global_name }}">Profile</a></li>
                                    <hr />
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item" type="submit">Logout</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('profile.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">Delete
                                                Account</button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"
                                    title="By logging in you agree with our Terms of Service">Login</a></li>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            <p class='text-end' id='currentTime'></p>
        </header>

        <main>
            @if (session('success'))
                <div class="d-flex justify-content-center">
                    <div class="toast show mb-4 text-bg-success border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="d-flex justify-content-center">
                    <div class="toast show mb-4 text-bg-warning border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            {{ $slot }}
            <h1 id='js-required'>Javascript is required to view this page. Please enable it in your browser settings
                and
                reload the page!</h1>
        </main>

        <footer class="text-center text-white">
            <!-- Grid container -->
            <div class="container p-4">
                <!-- Section: Social media -->
                <section class="mb-4">
                    <!-- Email -->
                    <a class="btn btn-outline-light btn-floating m-1" href="mailto:info@sm64romhacks.com"
                        role="button"><span class="fa-regular fa-envelope"></span></a>

                    <!-- Discord -->
                    <a class="btn btn-outline-light btn-floating m-1" href="http://discord.sm64romhacks.com"
                        role="button"><span class="fa-brands fa-discord"></span></a>

                    <!-- Twitch -->
                    <a class="btn btn-outline-light btn-floating m-1" href="https://www.twitch.tv/sm64romhacks"
                        role="button"><span class="fa-brands fa-twitch"></span></a>

                    <!-- YouTube -->
                    <a class="btn btn-outline-light btn-floating m-1" href="https://www.youtube.com/@sm64romhacks28"
                        role="button"><span class="fa-brands fa-youtube"></span></a>

                    <!-- Twitter -->
                    <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/sm64romhacks"
                        role="button"><span class="fa-brands fa-twitter"></span></a>

                    <!--PayPal -->
                    <a class="btn btn-outline-light btn-floating m-1" href="https://ko-fi.com/marvjungs"
                        role="button"><span class="fa-brands fa-paypal"></span></a>

                </section>
                <!-- Section: Social media -->

                <!-- Section: Links -->
                <section>
                    <!--Grid row-->
                    <div class="row">
                        <div class="col">
                            <b>Affiliates:</b>
                        </div>
                    </div>
                    <!--Grid row-->
                    <div class="row">
                        <div class="col">
                            <a href="https://www.smwcentral.net/" target="_blank"><img
                                    src="{{ asset('images/affiliates/smwc.gif') }}" alt="SMW Central"></a>
                        </div>
                        <div class="col">
                            <a href="http://www.mfgg.net/" target="_blank"><img
                                    src="{{ asset('images/affiliates/mfgg.png') }}" alt="Mario Fan Games Galaxy"></a>
                        </div>
                        <div class="col">
                            <a href="http://www.superluigibros.com/" target="_blank"><img
                                    src="{{ asset('images/affiliates/luigibros.png') }}"
                                    alt="Super Luigi Bros - Mario & Luigi Mega Fan Site"></a>
                        </div>
                        <div class="col">
                            <a href="https://www.youtube.com/user/SimpleFlips" target="_blank"><img
                                    src="{{ asset('images/affiliates/simpleflips.png') }}" alt="SimpleFlips"></a>
                        </div>
                        <div class="col">
                            <a href="http://smmdb.ddns.net/" target="_blank"><img
                                    src="{{ asset('images/affiliates/smmdb.png') }}"
                                    alt="Super Mario Maker Database"></a>
                        </div>
                        <div class="col">
                            <a href="https://64dd.org/" target="_blank"> <img
                                    src="{{ asset('images/affiliates/64DD_logo.png') }}" alt="64DD"></a>
                        </div>
                        <div class="col">
                            <a href="http://kuribo64.net/" target="_blank"> <img
                                    src="{{ asset('images/affiliates/kuribo64.jpg') }}" alt="Kuribo64"></a>
                        </div>
                        <div class="col">
                            <a href="https://neoromhacking.net/" target="_blank"> <img
                                    src="{{ asset('images/affiliates/neoromhacking.png') }}" alt="NeoRomhacking"></a>
                        </div>
                    </div>
                    <!--Grid row-->
                </section>
                <!-- Section: Links -->
            </div>
            <!-- Grid container -->

            <hr />

            <!-- Copyright -->
            <div class="text-center p-3">
                &copy;
                <a href="{{ route('home.index') }}">sm64romhacks.com</a>&nbsp;&#8226;&nbsp;
                <a href="{{ route('contact.index') }}">Contact Us!</a>&nbsp;&#8226;&nbsp;
                <a href="https://github.com/MarvJungs/sm64romhacks">Contribute!</a>&nbsp;&#8226;&nbsp;
                Version: {{ env('APP_VERSION') }}&nbsp;&#8226;&nbsp;
                <a href="{{ route('tos.index') }}">Terms of Service</a>&nbsp;&#8226;&nbsp;
                <a href="{{ route('privacy.name') }}">Privacy Policy</a>
                <br />
                2019 -
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <!-- Copyright -->
            </div>
        </footer>
        <!-- Footer -->
    </div>
    </div>
    <script type="text/javascript">
        document.getElementById('js-required').remove();
    </script>
</body>

</html>
