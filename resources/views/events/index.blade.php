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
                        @if (!$event->external)
                            <a class="btn btn-dark" href="{{ route('event.runs.create', ['event' => $event]) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Add Run"><x-bi-person-walking /></a>
                        @endif
                        <a class="btn btn-primary" href="{{ route('event.show', ['event' => $event]) }}"
                            @if ($event->external) target="_blank" @endif data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="View Event"><x-bi-eye /></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($event->description !== null)
                    <div class="card-text"><x-editor-js :blocks="$event->description['blocks']" />
                    </div>
                @endif
                <h2>Runs</h2>
                @if (count($event->runs) === 0)
                    <p class="card-text">There are no runs for this event yet! Once you have added a run it will show up
                        here to manage!</p>
                @else
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th scope="row">Romhack</th>
                                <th scope="row">Category</th>
                                <th scope="row">Run Type</th>
                                <th scope="row">Link to Videos</th>
                                <th scope="row">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->runs as $run)
                                <tr>
                                    <td>{{ $run->romhack }}</td>
                                    <td>{{ $run->category }}</td>
                                    <td>{{ $run->type }}</td>
                                    <td>
                                        @foreach ($run->videos as $video)
                                            <a href="https://www.youtube.com/watch?v={{ $video->videoid }}"
                                                target="_blank"><x-bi-camera-video-fill /></a>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-secondary"
                                            href="{{ route('event.runs.edit', ['event' => $event, 'run' => $run]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Edit Run"><x-bi-pencil /></a>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Delete Event">
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modal-confirm"
                                                data-bs-route="{{ route('event.runs.destroy', ['event' => $event, 'run' => $run]) }}"
                                                data-bs-method="DELETE"><x-bi-trash />
                                            </button>
                                        </span>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    @endforeach

</x-layout>
