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

    <section id="videos">
        <h2>Videos</h2>
        @if ($event->videos()->count() === 0)
            <p>No Videos are available yet. Check back later once all the runs have been added to the event!</p>
        @else
            <div class="row g-2">
                @foreach ($event->runs as $run)
                    @foreach ($run->videos as $video)
                        <div class="col-3">
                            <div class="position-relative">
                                <a href="https://www.youtube.com/watch?v={{ $video->videoID }}" target="_blank"
                                    class="btn position-absolute top-50 start-50 translate-middle"><x-bi-play-btn-fill
                                        class="img-fluid" height="8rem" width="8rem" /></a>
                                <time datetime="{{ $videos[$video->videoID]->getContentDetails()->getDuration() }}"
                                    class="position-absolute bottom-0 end-0 border border-primary">{{ (new DateInterval($videos[$video->videoID]->getContentDetails()->getDuration()))->format('%H:%I:%S') }}</time>
                                <img src="{{ $videos[$video->videoID]->getSnippet()->getThumbnails()->getStandard()->getUrl() }}"
                                    class="img-fluid" />
                            </div>
                            <p>{{ $videos[$video->videoID]->getSnippet()->getTitle() }}</p>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endif
    </section>
    <hr />

    <section id="schedule">
        <x-marathon-schedule :slug="$event->slug" />
    </section>

</x-layout>
