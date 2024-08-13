<x-layout>
    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-success me-3" href={{route('events.create')}}>
            <span class="fa-solid fa-plus"></span>
            Add Event
        </a>
        <a class="btn btn-warning" href="/moderation/disruptions">
            <span class="fa-solid fa-thunderbold"></span>
            Manage Disruptions
        </a>
    </div>
    <hr/>
    @foreach ($events as $event)
        <div class="card mb-4">
            <h5 class="card-header">
                <form action="/events/destroy" method="post">
                    @csrf
                    @method('DELETE')
                    {{ $event->name }}
                    <a class="btn btn-primary" href="/events/{{ $event->slug }}/edit">
                        <span class="fa-solid fa-pen"></span>
                    </a>
                    <button class="btn btn-danger" type="submit"><span class="fa-solid fa-trash"></span></button>
                    <a class="btn btn-warning" href="/moderation/disruptions/create">
                        <span class="fa-solid fa-cloud-bolt"></span>
                    </a>
                </form>
            </h5>
            <div class="card-body">
                <h5 class="card-title">From {{ $event->start_utc }} to {{ $event->end_utc }}</h5>
                @if (sizeof($event->disruptions) > 0)
                    @foreach ($event->disruptions as $disruption)
                        <p class="alert alert-danger d-flex align-items-center" role="alert">
                            <span class="fa-solid fa-exclamation bi flex-shrink-0 me-2" role="img"
                                aria-label="Danger:"></span>
                            <span class="m-1">{{ $disruption->created_at }}: {{ $disruption->text }} ({{$disruption->active ? 'active' : 'inactive'}})</span>
                        </p>
                    @endforeach
                @endif

                @if (isset($event->description))
                    @foreach (json_decode($event->description) as $item)
                        <p class="card-text">{!! parseEditorText($item) !!}</p>
                    @endforeach
                @endif
                <a href="/events/{{ $event->slug }}" class="btn btn-info">View Event</a>
            </div>
            <div class="card-footer text-body-secondary">
                Created at {{ $event->created_at }}
            </div>
        </div>
    @endforeach
</x-layout>
