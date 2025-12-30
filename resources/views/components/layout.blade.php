@props([
    'seoModel' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! seo($seoModel) !!}
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body data-bs-theme="dark">
    <div class="container">
        <x-navbar />
        <main>
            <p class="text-end" id="currentTime">&nbsp;</p>
            @foreach (session() as $item)
                <p>{{ gettype($value) }}</p>
            @endforeach
            {{ $slot }}
        </main>
    </div>
    <x-footer />

    <!--MODAL-->
    @stack('modals')
    <div class="modal fade" id="modal-confirm" tabindex="-1" aria-labelledby="#confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-title"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="POST" id="modal-form">
                        @csrf
                        <input type="hidden" name="_method" id="modal-form-method">
                        <button type="submit" class="btn btn-primary">Confirm
                            Action</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>


</html>
