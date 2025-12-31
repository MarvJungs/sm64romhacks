<x-layout>
    <h1 class="text-center">Create Event</h1>


    <form class="row g-3" method="post" id="manageEvent">
        @csrf
        @method('PUT')
        <div class="col-12">
            <label for="name" class="form-label">Eventname</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') ?? $event->name }}">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-12">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug"
                value="{{ old('slug') ?? $event->slug }}">
            @error('slug')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <div class="form-control" id="eventsEditor"></div>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-12">
            <label for="start_utc" class="form-label">Starttime</label><button type="button" class="btn p-1 mb-1"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Timezone: UTC"><x-bi-info-circle-fill
                    class="text-primary" /></button>
            <input type="datetime-local" class="form-control @error('start_utc') is-invalid @enderror" name="start_utc"
                value="{{ old('start_utc') ?? $event->start_utc }}">
            @error('start_utc')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-12">
            <label for="end_utc" class="form-label">Endtime</label><button type="button" class="btn p-1 mb-1"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Timezone: UTC"><x-bi-info-circle-fill
                    class="text-primary" /></button>
            <input type="datetime-local" class="form-control @error('end_utc') is-invalid @enderror" name="end_utc"
                value="{{ old('end_utc') ?? $event->end_utc }}">
            @error('end_utc')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="hidden" name="external" value="0">
                <input class="form-check-input" type="checkbox" name="external" value="1"
                    {{ $event->external ? 'checked' : '' }}>
                <label class="form-check-label" for="external">
                    External
                </label>
            </div>
        </div>
        <div class="col-12">
            <label for="" class="form-label">Link</label>
            <input type="url" class="form-control @error('external_url') is-invalid @enderror" name="external_url"
                value="{{ old('external_url') ?? $event->external_url }}">
            @error('external_url')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <input type="hidden" id="description" name="description"
            value="{{ old('description') ?? json_encode($event->description) }}" />
        <div class="col-12">
            <button id="eventSubmitButton" type="submit" class="btn btn-primary">Create Event</button>
        </div>
    </form>
</x-layout>
