<x-layout>
    <h1 class="text-center">Edit Version ({{ $hack->name }})</h1>

    <div class="d-flex align-items-start justify-content-center text-nowrap">

        <form method="POST" action={{ route('version.update', ['hack' => $hack, 'version' => $version]) }}>
            @csrf
            @method('PUT')
            <div class="row m-3">
                <div class="col">
                    <label for="versionname">Versionname</label>
                    <input type="text" name="versionname" class="form-control" id="versionname" value="{{$version->name}}" required>
                </div>
                <div class="col">
                    <label for="author">Author</label>
                    <input type="text" name="author" class="form-control" id="author" value="{{$authors}}" required>
                </div>
                <div class="col">
                    <label for="starcount">Starcount</label>
                    <input type="number" name="starcount" class="form-control" id="starcount" value="{{$version->starcount}}" required>
                </div>
                <div class="col">
                    <label for="releasedate">Releasedate</label>
                    <input type="date" name="releasedate" class="form-control" id="releasedate" value="{{$version->releasedate}}" required>
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
