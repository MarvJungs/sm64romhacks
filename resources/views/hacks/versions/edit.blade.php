<x-layout>
    <datalist id="authors">
        @foreach ($authors as $author)
            <option value="{{ $author->name }}">{{ $author->name }}</option>
        @endforeach
    </datalist>

    <form id="manageVersion" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-decoration-underline">Edit Version: {{ $version->name }} - {{ $version->romhack->name }}</h1>
        <div class="mb-3">
            <label for="version[name]" class="form-label">Version Label</label>
            <input type="text" class="form-control @error('version.name') is-invalid @enderror" name="version[name]"
                value="{{ old('version.name') ?? $version->name }}">
        </div>

        <div class="mb-3">
            <label for="version[starcount]" class="form-label">Starcount</label>
            <input type="number" class="form-control @error('version.starcount') is-invalid @enderror"
                name="version[starcount]" value="{{ old('version.starcount') ?? $version->starcount }}">
        </div>

        <div class="mb-3">
            <label for="version[releasedate]" class="form-label">Release Date</label>
            <input type="date" class="form-control @error('version.releasedate') is-invalid @enderror"
                name="version[releasedate]" value="{{ old('version.releasedate') ?? $version->releasedate }}">
        </div>

        <div class="mb-3">
            <label class="col-sm-2 col-form-label" for="authors">
                Authors<span data-bs-toggle="tooltip"
                    data-bs-title="Only enter One Author per Input Field. Press on the + for more Input Fields.">
                    <x-bi-info-circle />
                </span>
            </label>
            <div>
                <div class="mb-1"></div>
                <input type="text" class="form-control mb-2 me-2 @error('version.author.name') is-invalid @enderror"
                    list="authors" id="version[author][name]">
                @error('version.author.name.*')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="hidden" value="0" name="version[demo]">
                <input class="form-check-input @error('version.demo') is-invalid @enderror" type="checkbox"
                    value="1" name="version[demo]" @if (old('version.demo') ?? $version->demo) checked @endif>
                <label class="form-check-label" for="version[demo]">
                    Demo
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="hidden" value="0" name="version[recommened]">
                <input class="form-check-input @error('version.recommened') is-invalid @enderror" type="checkbox"
                    value="1" name="version[recommened]" @if (old('version.recommened') ?? $version->recommened) checked @endif>
                <label class="form-check-label" for="version[recommened]">
                    Recommened
                </label>
            </div>
        </div>

        @if (old('version.author.name'))
            @foreach (old('version.author.name') as $author)
                <input name="version[author][name][]" type="hidden" value="{{ $author }}" />
            @endforeach
        @else
            @foreach ($version->authors as $author)
                <input name="version[author][name][]" type="hidden" value="{{ $author->name }}" />
            @endforeach
        @endif

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Version</button>
        </div>
    </form>
</x-layout>
