<x-layout>
    <h1 class="text-decoration-underline">Edit Hack: {{ $hack->name }}</h1>
    <form method="POST" id="manageRomhack" enctype="multipart/form-data">

        @method('PUT')
        <datalist id="tagnames">
            @foreach ($tags as $tag)
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endforeach
        </datalist>

        <datalist id="authors">
            @foreach ($authors as $author)
                <option value="{{ $author->name }}">{{ $author->name }}</option>
            @endforeach
        </datalist>

        <h2>General Data about the Hack</h2>
        <div class="row mb-3">
            <label for="romhack[name]" class="col-sm-2 col-form-label">
                Hackname
            </label>
            <div class="col-sm-10">
                <input type="text" name="romhack[name]"
                    class="form-control @error('romhack.name') is-invalid @enderror"
                    value="{{ $hack->name ?? old('romhack.name') }}">
                @error('romhack.name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="tagname[]">
                Tags
                <span data-bs-toggle="tooltip"
                    data-bs-title="Only enter one Tag per Input Field. Press the Enter Key to add it.">
                    <x-bi-info-circle />
                </span>
            </label>
            <div class="col-sm-10">
                <div class="mb-1"></div>
                <input type="text" class="form-control mb-2" list="tagnames" id="romhack[tag][name]">
            </div>
        </div>

        @can('megapack', App\Models\Romhack::class)
            <div class="col-sm-10 offset-sm-2 mb-3">
                <div class="form-check">
                    <label for="megapack" class="form-check-label">Megapack</label>
                    <input type="hidden" name="romhack[megapack]" class="form-check-input" value="0">
                    <input type="checkbox" name="romhack[megapack]" class="form-check-input" value="1"
                        {{ $hack->megapack ? 'checked' : '' }}>
                    @error('romhack.megapack')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endcan
        <div class="row mb-3">
            <label for="editor" class="col-sm-2 col-form-label">
                Description
            </label>
            <div class="col-sm-10">
                <div class="form-control @error('romhack.description.blocks') is-invalid @enderror" id="editor">
                    @csrf
                </div>
                @error('romhack.description.blocks')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <hr />

        <div class="row mb-3">
            <h2>Promotional Media</h2>
            <div class="col">
                <label for="romhack[videolink]">Video Link</label>
                <input type="url" name="romhack[videolink]"
                    class="form-control @error('romhack.videolink') is-invalid @enderror" id="videolink"
                    value="{{ $hack->videolink }}">
                @error('romhack.videolink')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col">
                <label for="romhack[image][]">Images</label>
                <input type="file" name="romhack[image][]" id="image[]"
                    class="form-control @error('romhack.image') is-invalid @enderror" multiple>
                @error('romhack.image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <div class="row">
            <div class="col">
                <button class="form-control btn btn-primary" type="submit" id="submissionButton">Submit</button>
            </div>
        </div>
        <input type="hidden" name="romhack[description]" id="romhack.description"
            value="{{ json_encode($hack->description) ?? '[]' }}">

        @if (!is_null(old('romhack.version.author.name')))
            @foreach (old('romhack.version.author.name') as $author)
                <input name="romhack[version][author][name][]" type="hidden" value="{{ $author }}" />
            @endforeach
        @endif

        @foreach ($hack->romhacktags as $tag)
            <input name="romhack[tag][name][]" type="hidden" value="{{ $tag->name }}" />
        @endforeach

    </form>
    </div>
</x-layout>
