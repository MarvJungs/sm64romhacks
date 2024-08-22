<x-layout>
    <h1 class="text-center text-decoration-underline">Event Creation Form</h1>
    <form method="POST" action="{{ route('events.update', ['event' => $event]) }}" id="eventForm">
        @csrf
        @method('PUT')
        <div class="row mb-4">
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" class="form-control" name="slug" value="{{ $event->slug }}" required>
            </div>
            <div class="col">
                <label for="name">Event Title</label>
                <input íd="name" class="form-control" name="name" value="{{ $event->name }}" required>
            </div>
        </div>
        <div class="hstack gap-3 mb-4">
            <div class="p-2">
                <label for="start_utc">Start Time (in UTC)</label>
                <input type="datetime-local" id="start_utc" class="form-control w-auto" name="start_utc"
                value="{{ $event->start_utc }}">
            </div>
            <div class="p-2">
                <label for="end_utc">End Time (in UTC)</label>
                <input type="datetime-local" id="end_utc" class="form-control w-auto" name="end_utc"
                value="{{ $event->end_utc }}">
            </div>
            <div class="p-2">
                <label for="marathon">Marathon Or Special Event?</label>
                <input type="checkbox" name="marathon" id="marathon" @checked($event->marathon)>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div id="editor-description"></div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="description" id="description" value="{{ $event->description }}">
    </form>
</x-layout>
