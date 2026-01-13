<x-layout>
    <datalist id="hacks">
        @foreach ($hacks as $hack)
            <option value="{{ $hack->name }}"></option>
        @endforeach
    </datalist>

    <form id="addRunToEvent" method="post">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-3">
            <label for="hack" class="col-2 form-col-label">Played ROM Hack</label>
            <div class="col-9">
                <input class="form-control @error('romhack') is-invalid @enderror" type="text" name="romhack"
                    list="hacks" value="{{ old('romhack') ?? $run->romhack }}">
                @error('romhack')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <label for="category" class="col-2 form-col-label">Played Category</label>
            <div class="col-9">
                <input class="form-control @error('category') is-invalid @enderror" type="text" name="category"
                    value="{{ old('category') ?? $run->category }}">
                @error('category')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <fieldset class="row g-3 mb-3">
            <legend for="type" class="col-2 col-form-label">Run Type</legend>
            <div class="col-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="standalone" value="standalone"
                        @if ($run->type === 'standalone') checked @endif>
                    <label class="form-check-label" for="standalone">Standalone Run</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="coop" value="coop"
                        @if ($run->type === 'coop') checked @endif>
                    <label class="form-check-label" for="coop">Cooperative</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="race" value="race"
                        @if ($run->type === 'race') checked @endif>
                    <label class="form-check-label" for="race">Race</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="showcase" value="showcase"
                        @if ($run->type === 'showcase') checked @endif>
                    <label class="form-check-label" for="showcase">Showcase</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="gameshow" value="gameshow"
                        @if ($run->type === 'gameshow') checked @endif>
                    <label class="form-check-label" for="gameshow">Gameshow</label>
                </div>
            </div>
        </fieldset>

        <div class="row g-3 mb-3" id="authors" data-enable-multiple-fields="true">
            <div class="row g-2 mb-2">
                <label for="author" class="col-2 form-col-label">
                    Runners
                    <span data-bs-toggle="tooltip"
                        data-bs-title="Click on the Plus-Icon to add more Runners to the run!"><x-bi-info-circle-fill /></span>
                    <button class="btn" id="addAuthor" type="button"><x-bi-plus /></button>
                </label>
                @if (old('author') === null)
                    @foreach ($run->authors as $index => $author)
                        @if ($index > 0)
                            <div class="row g-2 mb-2">
                        @endif

                        <div class="@if ($index > 0) offset-2 @endif col-9">
                            <input class="form-control mb-2" type="text" name="author[]" value="{{ $author->name }}"
                                required>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger"
                                @if ($index === 0) disabled @endif><x-bi-trash-fill /></button>
                        </div>
            </div>
            @endforeach
        @else
            @foreach (old('author') as $index => $author)
                @if ($index > 0)
                    <div class="row g-2 mb-2">
                @endif
                <div class="@if ($index > 0) offset-2 @endif col-9">
                    <input class="form-control mb-2 @error("author.$index") is-invalid @enderror" type="text"
                        name="author[]" list="runners" value="{{ old("author.$index") }}" required>
                    @error("author.$index")
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-1">
                    <button class="btn btn-danger" type="button"
                        @if ($index == 0) disabled @endif><x-bi-trash-fill /></button>
                </div>
        </div>
        @endforeach
        @endif
        </div>
        <hr />

        <div class="row g-3 mb-3" id="videolinks" data-enable-multiple-fields="true">
            <div class="row g-2 mb-2">
                <label class="col-2 form-col-label" for="videolink">
                    Videolinks
                    <span data-bs-toggle="tooltip"
                        data-bs-title="Click on the Plus-Icon to Add more Videos to the run! This can be useful if a run got split up into more than one parts. Videos must be a YouTube-Video link and is required"><x-bi-info-circle-fill /></span>
                    <button class="btn" id="addVideo" type="button"><x-bi-plus /></button>
                </label>
                @if (old('videolink') === null)
                    @foreach ($run->videos as $index => $video)
                        @if ($index > 0)
                            <div class="row g-2 mb-2">
                        @endif

                        <div class="@if ($index > 0) offset-2 @endif col-9">
                            <input class="form-control mb-2" type="url" name="videolink[]"
                                value="{{ $video->link }}" required>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger"
                                @if ($index === 0) disabled @endif><x-bi-trash-fill /></button>
                        </div>
            </div>
            @endforeach
        @else
            @foreach (old('videolink') as $index => $videolink)
                @if ($index > 0)
                    <div class="row g-2 mb-2">
                @endif
                <div class="@if ($index > 0) offset-2 @endif col-9">
                    <input class="form-control mb-2 @error("videolink.$index") is-invalid @enderror" type="url"
                        name="videolink[]" value="{{ old("videolink.$index") }}" required>
                    @error("videolink.$index")
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-1">
                    <button class="btn btn-danger" type="button"
                        @if ($index == 0) disabled @endif><x-bi-trash-fill /></button>
                </div>
        </div>
        @endforeach
        @endif
        </div>

        <div class="row g-3">
            <div class="offset-2 col-3">
                <button class="btn btn-primary" type="submit">Update Run</button>
            </div>
        </div>
    </form>
</x-layout>
