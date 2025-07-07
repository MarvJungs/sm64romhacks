<x-layout>
    <h1 class="text-center text-decoration-underline">Hack Submission Form</h1>
    {{-- @dd($errors); --}}
    <form method="POST" id="manageRomhack" action="{{ route('hack.store', ['hack' => $hack]) }}" enctype="multipart/form-data">
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
                    <img src={{ asset('images/icons/info-circle.svg') }} />
                </span>
            </label>
            <div class="col-sm-10">
                <div class="mb-1"></div>
                <input type="text" class="form-control mb-2" list="tagnames" id="romhack[tag]">
            </div>
        </div>

        @if (Auth::user()->hasRole('admin'))
            <div class="col-sm-10 offset-sm-2 mb-3">
                <div class="form-check">
                    <label for="megapack" class="form-check-label">Megapack</label>
                    <input type="hidden" name="romhack[megapack]" class="form-check-input" value="0">
                    <input type="checkbox" name="romhack[megapack]" class="form-check-input" value="1" {{ $hack->megapack ? 'checked' : '' }}>
                </div>
            </div>
        @endif
        <div class="row mb-3">
            <label for="editor" class="col-sm-2 col-form-label">
                Description
            </label>
            <div class="col-sm-10">
                <div class="form-control @error('romhack.description') is-invalid @enderror" id="editor">
                    @csrf
                </div>
                @error('romhack.description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <hr />

        @if (!$hack->exists)
            <h2>Version Specific Data</h2>
            <div class="row mb-4">
                <div class="col">
                    <label for="romhack[version][name]">Versionname</label>
                    <input type="text" name="romhack[version][name]" id="versionname"
                        class="form-control @error('romhack.version.name') is-invalid @enderror"
                        value="{{ old('romhack.version.name') }}">
                    @error('romhack.version.name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="romhack[version][releasedate]">Releasedate</label>
                    <input type="date" name="romhack[version][releasedate]" id="releasedate"
                        class="form-control @error('romhack.version.releasedate') is-invalid @enderror"
                        value="{{ old('romhack.version.releasedate') }}">
                    @error('romhack.version.releasedate')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="starcount">Starcount</label>
                    <input type="number" name="romhack[version][starcount]" id="starcount"
                        class="form-control @error('romhack.version.starcount') is-invalid @enderror"
                        value="{{ old('romhack.version.starcount') }}">
                    @error('romhack.version.starcount')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="patchfile">Patchfile</label>
                    <input type="file" name="romhack[version][patchfile]" id="patchfile" class="form-control"
                        @error('romhack.version.patchfile') is-invalid @enderror
                        value="{{ old('romhack.version.patchfile') }}">
                    @error('romhack.version.patchfile')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="authors">
                    Authors<span data-bs-toggle="tooltip"
                        data-bs-title="Only enter One Author per Input Field. Press on the + for more Input Fields.">
                        <img src={{ asset('images/icons/info-circle.svg') }} />
                    </span>
                </label>
                <div class="col-sm-10">
                    <div class="mb-1"></div>
                    <input type="text"
                        class="form-control mb-2 me-2 @error('romhack.version.author.name') is-invalid @enderror"
                        list="authors" id="romhack[version][author][name]">
                    @error('romhack.version.author.name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <hr />
        @endif


        <div class="row mb-3">
            <h2>Promotional Media</h2>
            <div class="col">
                <label for="romhack[videolink]">Video Link</label>
                <input type="url" name="romhack[videolink]"
                    class="form-control @error('romhack.videolink') is-invalid @enderror" id="videolink" value="{{ $hack->videolink }}">
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
            value="{{ $hack->description ?? '[]' }}">

        @if (!is_null(old('romhack.version.author.name')))
            @foreach (old('romhack.version.author.name') as $author)
                <input name="romhack[version][author][name][]" type="hidden" value="{{ $author }}" />
            @endforeach
        @endif

        @if ($hack->exists)
            @foreach ($hack->romhacktags as $tag)
                <input name="romhack[tag][]" type="hidden" value="{{ $tag->name }}" />
            @endforeach
        @else
            @if (!is_null(old('tagInput')))
                @foreach (old('tagInput') as $author)
                    <input name="romhack[tag][]" type="hidden" value="{{ $author }}" />
                @endforeach
            @endif
        @endif

    </form>
    </div>
</x-layout>
