<x-layout>
    <h1 class="mb-4">Manage Event Disruptions in Realtime</h1>
    @foreach ($events as $event)
        @if (sizeof($event->disruptions) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ $event->name }}</h2>
                </div>
                <div class="card-body">
                    @foreach ($event->disruptions as $disruption)
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex flex-row align-items-center justify-content-between me-1">
                                <div>
                                    <span class="fa-solid fa-exclamation me-2"></span>
                                    <span class="me-2">
                                        {{ $disruption->text }}
                                    </span>
                                </div>
                                <form class="justify-content-center"
                                    action="{{ route('disruptions.update', $disruption) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-primary" type="submit">
                                        @if ($disruption->active)
                                            <span class="fa-solid fa-toggle-off"></span>
                                        @else
                                            <span class="fa-solid fa-toggle-on"></span>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</x-layout>
