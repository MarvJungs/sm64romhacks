<x-layout>
    <div class="d-flex justify-content-between gap-3">
        <input type="text" class="form-control" id="hacknameFilter" placeholder="Search for Hacknames..." />
        <input type="text" class="form-control" id="authornameFilter" placeholder="Search for Authornames..." />
        <input type="text" class="form-control" id="releasedateFilter" placeholder="Search for Releasedate..." />
        <div class="form-check align-items-center">
            <input type="checkbox" class="form-check-input" id="megapackFilter" /><label class="form-check-label"
                for="megapackFilter">Megapack</label>
        </div>
        <select class="form-select" id="tagsFilter">
            <option value="">Select A Tag to Filter!</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <a class="btn btn-primary text-nowrap" href="{{ route('hack.random') }}"> <x-bi-shuffle /> Random Hack </a>
        @can('create', \App\Models\Romhack::class)
            <a class="btn btn-success text-nowrap" href="{{ route('hack.create') }}"><x-bi-plus-circle /> Add Hack</a>
        @endcan
    </div>
    <hr />
    <section id="hacksTable">
        <div class="d-flex justify-content-center" id="spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <p>Found <span id="counter">0</span> Entrances
        <p>
    </section>
</x-layout>
