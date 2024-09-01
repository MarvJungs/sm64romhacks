<x-layout>
    <h1 class="text-center text-decoration-underline">Edit Hack Submission Form</h1>

    <div class="d-flex justify-content-center">
        <form class="w-100" method="POST" action="{{ route('hacks.update', ['hack' => $hack]) }}"
            enctype="multipart/form-data" id="hackForm">
            @csrf
            @method('PATCH')

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="name">Hackname</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="name" value="{{ $hack->name }}"
                        required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="tagname">Tags</label>
                <div class="col-sm-10">
                    <input type="text" name="tagname" class="form-control" id="tagname"
                        value="{{ implode(', ', $hack->tags()->pluck('name')->toArray()) }}">
                </div>
            </div>

            @if (Auth::check() && Auth::user()->hasRole(705528172581486704))
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="megapack" id="megapack">
                            <label for="megapack" class="form-check-label">Megapack</label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="videolink">Videolink</label>
                <div class="col-sm-10">
                    <input type="url" name="videolink" class="form-control" id="videolink"
                        value="{{ $hack->videolink }}">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="image">Images</label>
                <div class="col-sm-10">
                    <input type="file" name="image[]" class="form-control mb-4" id="image" multiple>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Manage Images
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">Version</div>
                <div class="col">Recommened</div>
                <div class="col">Demo</div>
            </div>
            @foreach ($hack->versions as $version)
                <div class="row mb-3">
                    <div class="col">{{ $version->name }}</div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" name="recommened[]" value="{{ $version->id }}"
                            @checked($version->recommened)>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" name="demo[]" value="{{ $version->id }}"
                            @checked($version->demo)>
                    </div>
                </div>
            @endforeach

            <div class="row mb-4">
                <div class="col">
                    <label for="editor.description">Description</label>
                    <div id="editor-description"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <button class="form-control btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
            <input type="hidden" name="description" id="description" value="{{ $hack->description }}">
        </form>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Here you can manage your promotional images!
                        </p>
                        <p>
                            To get rid of an already existing image, just
                            press on the trashcan button on the top right corner of the image you wish to delete!
                        </p>
                        <div class="row">
                            @foreach ($hack->images as $image)
                                <form class="col mb-4" action="{{ route('image.destroy', $image) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ Storage::url($image->filename) }}" height="128">
                                        <button class="btn btn-danger position-absolute top-0 end-0" type="submit">
                                            <span class="fa-solid fa-trash"></span>
                                        </button>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
