<x-layout>
    <h1 class="text-center text-decoration-underline">Hack Submission Form</h1>

    <div class="d-flex align-items-start text-nowrap">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home"
                type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Hack Metadata</button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Version
                Metadata</button>
        </div>

        <form method="POST" action="{{ route('hacks.store') }}" enctype="multipart/form-data" id="hackForm">
            @csrf

            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                    aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="row m-3">
                        <div class="col">
                            <label for="name">Hackname</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="col">
                            <label for="tagname">Tags</label>
                            <input type="text" name="tagname" class="form-control" id="tagname">
                        </div>
                        <div class="col">
                            <label for="image[]">Images</label>
                            <input type="file" name="image[]" id="image[]" class="form-control" multiple>
                        </div>
                        @if ((Auth::check() && Auth::user()->role->priority <= 2))
                            <div class="col">
                                <div class="form-check">
                                    <label for="megapack" class="form-check-label">Megapack</label>
                                    <input type="checkbox" name="megapack" id="megapack" class="form-check-input">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <div id="editor-description"></div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col">
                        <button class="form-control btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
            <input type="number" name="count" id="count" value="1" hidden>
            <input type="hidden" name="description" id="description" value="{{ $hack->description }}">

        </form>
    </div>
</x-layout>
