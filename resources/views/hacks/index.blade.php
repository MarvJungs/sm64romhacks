<x-layout>
    <div class="row">
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
            <select id="sortFilter" class="form-select">
                <option value="">Sort By</option>
                <option value="name_asc">Hackname (ASC)</option>
                <option value="name_desc">Hackname (DESC)</option>
                <option value="releasedate_asc">Release Date (ASC)</option>
                <option value="releasedate_desc">Release Date (DESC)</option>
                <option value="starcount_desc">Starcount (ASC)</option>
                <option value="starcount_desc">Starcount (DESC)</option>
                <option value="downloads_asc">Downloads (ASC)</option>
                <option value="downloads_desc">Downloads (DESC)</option>
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
    </div>
    <hr />
    @include('hacks.overview', ['hacks' => $hacks])
</x-layout>
