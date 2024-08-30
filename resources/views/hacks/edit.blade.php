<x-layout>
    <h1 class="text-center text-decoration-underline">Edit Hack Submission Form</h1>

    <div class="d-flex justify-content-center text-nowrap">
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
    </div>
</x-layout>
