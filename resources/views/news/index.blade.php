<x-layout>
    <div class="d-flex justify-content-between mb-4">
        <h1>News</h1>
        @if (Auth::check() && Auth::user()->hasRole(705528172581486704))
            <a href="/news/create" class="align-self-center btn btn-success">
                <span class="fa-solid fa-plus"></span>
                Create New Newspost
            </a>
        @endif
    </div>
    @foreach ($news as $message)
        <x-cards.news :message="$message" />
    @endforeach
</x-layout>
