<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>sm64romhacks - {{ $title ?? '' }}</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body data-bs-theme="dark">
    <div class="container">
        <x-navbar />
        <main>
            @foreach (session() as $item)
                <p>{{ gettype($value) }}</p>
            @endforeach
            {{ $slot }}
        </main>
    </div>
    <x-footer />
</body>


</html>
