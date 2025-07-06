<x-layout>
    <div class="d-flex justify-content-between gap-3">
        <input class="form-control" id="hacknameFilter" placeholder="Search for Hacknames..." />
        <input class="form-control" id="authornameFilter" placeholder="Search for Authornames..." />
        <input class="form-control" id="releasedateFilter" placeholder="Search for Releasedate..." />
        <select class="form-select" id="tagsFilter">
            <option value="">Select A Tag to Filter!</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <a class="btn btn-primary text-nowrap" href="/hacks/random"> Random Hack </a>
        @if (Auth::check() && Auth::user()->hasRole('Admin'))
            <a class="btn btn-success text-nowrap" href="/hacks/manage">Add Hack</a>
        @endif
    </div>
    <hr />
    <section id="hacksTable">
        <div class="d-flex justify-content-center" id="spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </section>
    <img class="movingImage" src="/images/cart.webp" sizes="64" height="64" />
</x-layout>
