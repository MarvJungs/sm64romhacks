<x-layout>
    <h1 class="text-center">Add New Version ({{ $hack->name }})</h1>
    <form method="POST" action="{{ route('version.store', ['hack' => $hack]) }}" enctype="multipart/form-data"
        id="hackForm">
        @csrf
        <datalist id="authors">
            @foreach ($authors as $author)
                <option value="{{ $author }}">{{ $author }}</option>
            @endforeach
        </datalist>


        <div class="row mb-3 row-cols-2">
            <div class="col">
                <label for="versionname">Versionname</label>
                <input type="text" name="versionname" class="form-control" id="versionname" required>
            </div>
            <div class="col">
                <label for="starcount">Starcount</label>
                <input type="number" name="starcount" class="form-control" id="starcount" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="releasedate">Releasedate</label>
                <input type="date" name="releasedate" class="form-control" id="releasedate">
            </div>
            <div class="col">
                <label for="patchfile">Patchfile</label>
                <input type="file" class="form-control" id="patchfile" name="patchfile" required>
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

        <div class="row m-3">
            <div class="col">
                <button class="form-control btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form>
</x-layout>
