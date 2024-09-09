<x-layout>
    <h1 class="text-center text-decoration-underline">Event Creation Form</h1>
    <form method="POST" action="{{ route('events.store') }}" id="eventForm">
        @csrf

        <div class="row mb-4">
            <div class="col">
                <label for="slug">Slug</label>
                <input id="slug" class="form-control" name="slug" required>
            </div>
            <div class="col">
                <label for="title">Event Title</label>
                <input íd="title" class="form-control" name="title" required>
            </div>
        </div>
        <div class="hstack gap-3 mb-4">
            <div class="p-2">
                <label for="start_utc">Start Time (in UTC)</label>
                <input type="datetime-local" id="start_utc" class="form-control w-auto" name="start_utc">
            </div>
            <div class="p-2">
                <label for="end_utc">End Time (in UTC)</label>
                <input type="datetime-local" id="end_utc" class="form-control w-auto" name="end_utc">
            </div>
            <div class="p-2">
                <label for="marathon">Marathon Or Special Event?</label>
                <input type="checkbox" name="marathon" id="marathon" @checked(false)>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="mb-2" for="editor-description">
                    Description <span class="fa-solid fa-info btn btn-primary rounded-pill ms-2"
                        data-bs-toggle="tooltip"
                        data-bs-title="Type '/' in the editor box to call the context menu!"></span>
                </label>
                <div id="editor-description"></div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="row w-25">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Add Event!</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="description" id="description">
    </form>
</x-layout>
