<x-layout>
    <h1 class="text-center text-decoration-underline">Hack Submission Form</h1>

    <form method="POST" action="{{ route('hacks.store') }}" enctype="multipart/form-data" id="hackForm">
        @csrf
        <h2>General Data about the Hack</h2>
        <div class="row m-3">
            <div class="col">
                <label for="name">Hackname</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="col">
                <label for="tagname">Tags</label>
                <input type="text" name="tagname" class="form-control" id="tagname">
            </div>

            @if (Auth::check() && Auth::user()->hasRole(705528172581486704))
                <div class="d-flex col align-items-end">
                    <div class="form-check">
                        <label for="megapack" class="form-check-label">Megapack</label>
                        <input type="checkbox" name="megapack" id="megapack" class="form-check-input">
                    </div>
                </div>
            @endif
        </div>
        <div class="row mb-4">
            <div class="col">
                <label for="editor-description">Description</label>
                <div id="editor-description"></div>
            </div>
        </div>

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
            <div class="col">
                <label for="authors">Authors</label>
                <input type="text" name="author" id="author" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <h2>Promotional Media</h2>
            <div class="col">
                <label for="videolink">Video Link</label>
                <input type="url" name="videolink" class="form-control" id="videolink">
            </div>
            <div class="col">
                <label for="logo">Logo</label>
                <input type="file" name="logo" class="form-control" id="logo">
            </div>
            <div class="col">
                <label for="image[]">Images</label>
                <input type="file" name="image[]" id="image[]" class="form-control" multiple>
            </div>
        </div>


        <div class="row m-3">
            <div class="col">
                <button class="form-control btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
        <input type="hidden" name="description" id="description">

    </form>
    </div>
</x-layout>
