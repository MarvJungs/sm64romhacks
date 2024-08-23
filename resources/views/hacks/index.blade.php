<x-layout>
    <div class="row mb-3">
        <div class="col">
            <input name="hacknameFilter" id="hacknameFilter" class="form-control" type="text"
                placeholder="Search for Hacknames...">
        </div>
        <div class="col">
            <input name="authornameFilter" id="authornameFilter" class="form-control" type="text"
                placeholder="Search for Authornames...">
        </div>
        <div class="col">
            <input name="releasedateFilter" id="releasedateFilter" class="form-control" type="text"
                placeholder="Search for Release Dates...">
        </div>
        <div class="col">
            <select name="tagFilter" id="tagFilter" class="form-select">
                <option value="">Select A Category</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <a class="btn btn-primary" href="/hacks/random">
                <span class="fa-solid fa-shuffle"></span>
                Random Hack
            </a>
        </div>
        @if (Auth::check())
            <div class="col">
                <a class="btn btn-success" href="/hacks/create">
                    <span class="fa-solid fa-plus"></span>
                    Add Hack
                </a>
            </div>
        @endif
        <hr />
    </div>
    @include('hacks.overview', ['hacks' => $hacks])
</x-layout>
