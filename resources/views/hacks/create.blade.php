<x-layout>
    <h1 class="text-center text-decoration-underline">Hack Submission Form</h1>

    <form method="POST" action="{{ route('hacks.store') }}" enctype="multipart/form-data" id="hackForm">
        @csrf

        <datalist id="tagnames">
            @foreach ($tags as $tag)
                <option value="{{ $tag }}">{{ $tag }}</option>
            @endforeach
        </datalist>

        <datalist id="authors">
            @foreach ($authors as $author)
                <option value="{{ $author }}">{{ $author }}</option>
            @endforeach
        </datalist>

        <h2>General Data about the Hack</h2>
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Hackname</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="tagname[]">
                Tags
                <span
                    class="fa-solid fa-info btn btn-primary rounded-pill ms-2" data-bs-toggle="tooltip"
                    data-bs-title="Only enter One Tag per Input Field. Press on the + for more Input Fields."></span>
                <button class="btn" id="addTag"><span class="fa-solid fa-plus"></span></button></label>
            <div id="tagsColumn" class="col-sm-10" name="tagname">
                <div class="d-flex justify-content-between">
                    <input type="text" name="tagname[]" class="form-control mb-2 me-2" list="tagnames">
                    <button class="btn btn-danger mb-2 removeTag">
                        <span class="fa-solid fa-minus"></span>
                    </button>
                </div>
            </div>
        </div>

        @if (Auth::check() && Auth::user()->hasRole(705528172581486704))
            <div class="col-sm-10 offset-sm-2 mb-3">
                <div class="form-check">
                    <label for="megapack" class="form-check-label">Megapack</label>
                    <input type="checkbox" name="megapack" id="megapack" class="form-check-input">
                </div>
            </div>
        @endif
        <div class="row mb-3">
            <label for="editor-description" class="col-sm-2 col-form-label">
                Description
            </label>
            <div class="col-sm-10">
                <div id="editor-description"></div>
            </div>
        </div>
        <hr />

        <h2>Version Specific Data</h2>
        <div class="row mb-4">
            <div class="col">
                <label for="versionname">Versionname</label>
                <input type="text" name="versionname" id="versionname" class="form-control" required>
            </div>
            <div class="col">
                <label for="releasedate">Releasedate</label>
                <input type="date" name="releasedate" id="releasedate" class="form-control" required>
            </div>
            <div class="col">
                <label for="starcount">Starcount</label>
                <input type="number" name="starcount" id="starcount" class="form-control" required>
            </div>
            <div class="col">
                <label for="patchfile">Patchfile</label>
                <input type="file" name="patchfile" id="patchfile" class="form-control" required>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-sm-2 col-form-label" for="authors">
                Authors<span class="fa-solid fa-info btn btn-primary rounded-pill ms-2" data-bs-toggle="tooltip"
                    data-bs-title="Only enter One Author per Input Field. Press on the + for more Input Fields."></span>
                <button class="btn" id="addAuthor">
                    <span class="fa-solid fa-plus"></span>
                </button>
            </label>
            <div id="authorsColumn" class="col-sm-10" name="author">
                <div class="d-flex justify-content-between">
                    <input type="text" name="author[]" class="form-control mb-2 me-2" list="authors">
                    <button class="btn btn-danger mb-2 removeAuthor">
                        <span class="fa-solid fa-minus"></span>
                    </button>
                </div>
            </div>
        </div>
        <hr />

        <div class="row mb-3">
            <h2>Promotional Media</h2>
            <div class="col">
                <label for="videolink">Video Link</label>
                <input type="url" name="videolink" class="form-control" id="videolink">
            </div>

            <div class="col">
                <label for="image[]">Images</label>
                <input type="file" name="image[]" id="image[]" class="form-control" multiple>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <button class="form-control btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
        <input type="hidden" name="description" id="description">

    </form>
    </div>
</x-layout>
