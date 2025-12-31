<x-layout>
    <div class="row">
        <div class="col">
            <h1>Events</h1>
        </div>
        <div class="col text-end">
            <a class="btn btn-success" href="{{ route('event.create') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Create Event"><x-bi-plus /></a>
        </div>
    </div>

    @foreach ($events as $event)
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <div>
                        <a class="btn btn-secondary" href="{{ route('event.edit', ['event' => $event]) }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Event"><x-bi-pencil />
                        </a>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Event">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                data-bs-route="{{ route('event.destroy', ['event' => $event]) }}"
                                data-bs-method="DELETE"><x-bi-trash />
                            </button>
                        </span>
                        <a class="btn btn-primary" href="{{ route('event.show', ['event' => $event]) }}"
                            @if ($event->external) target="_blank" @endif data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="View Event"><x-bi-eye /></a>
                    </div>
                </div>
            </div>
            @if ($event->description !== null)
                <div class="card-body">
                    <div class="card-text"><x-editor-js :blocks="$event->description['blocks']" /></p>
                    </div>
                </div>
            @endif
        </div>
    @endforeach

</x-layout>
