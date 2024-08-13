<x-layout>
    <h1 class="text-center">Add New Version ({{ $hack->name }})</h1>

    <div class="d-flex align-items-start text-nowrap">

        <form method="POST" action="{{ route('version.store', ['hack' => $hack]) }}" enctype="multipart/form-data">
            @csrf


            <div class="row m-3">
                <div class="col">
                    <label for="versionname">Versionname</label>
                    <input type="text" name="versionname" class="form-control" id="versionname" required>
                </div>
                <div class="col">
                    <label for="author">Author</label>
                    <input type="text" name="author" class="form-control" id="author" required>
                </div>
                <div class="col">
                    <label for="starcount">Starcount</label>
                    <input type="number" name="starcount" class="form-control" id="starcount" required>
                </div>
                <div class="col">
                    <label for="releasedate">Releasedate</label>
                    <input type="date" name="releasedate" class="form-control" id="releasedate">
                </div>
                <div class="col">
                    <label for="patchfile">Patchfile</label>
                    <input type="file" class="form-control" id="patchfile" name="patchfile" required>
                </div>
            </div>

            <input type="text" name="hack_id" value={{ $hack->id }} hidden>

            <div class="row m-3">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
    </div>
    </form>
    </div>
</x-layout>
