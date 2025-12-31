<x-layout :seoModel="$event">
    <h1 class="text-decoration-underline text-center">
        {{ $event->name }}
    </h1>
    <p id="countdown"></p>
    <hr />

    <section id="description">
        @if (!is_null($event->description))
            <x-editor-js :blocks="$event->description['blocks']" />
        @endif
    </section>
    <hr />

    <section id="schedule">
        <x-marathon-schedule :slug="$event->slug" />
    </section>

</x-layout>
