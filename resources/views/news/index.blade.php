<x-layout>
    <h1 class="text-decoration-underlined">
        Recent News
        @if (Auth::check() && Auth::user()->hasRole('admin'))
            <a class="btn btn-success" href="{{ route('newspost.manage') }}">Add Newspost</a>
        @endauth
</h1>
@foreach ($newsposts as $newspost)
    <div class="card mb-5">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>{{ $newspost->title }}</h4>
                <div>
                    <a class="btn btn-primary text-decoration-none"
                        href="{{ route('newspost.show', ['newspost' => $newspost]) }}"><img
                            src="/icons/view.svg" /></a>
                    @auth
                        @if (Auth::user()->isAuthorOf($newspost))
                            <a class="btn btn-info text-decoration-none"
                                href="{{ route('newspost.manage', ['newspost' => $newspost]) }}"><img
                                    src="/icons/edit.svg" /></a>
                            <a class="btn btn-danger text-decoration-none"
                                href="{{ route('newspost.delete', ['newspost' => $newspost]) }}"><img
                                    src="/icons/delete.svg" /></a>
                        @endif
                    @endauth
                </div>
            </div>
            <p class="text-info">Written by <img src="/storage/{{ $newspost->user->avatar }}" height="32"
                    width="32" /> <a href="">{{ $newspost->user->name }}</a> at <span
                    class="time">{{ $newspost->created_at }}</span> (last
                updated at <span class="time">{{ $newspost->updated_at }}</span>)</p>
        </div>
        <div class="card-body">
            <div class="card-text">
                <x-editor-js :blocks="$newspost->text['blocks']" />
            </div>
        </div>
    </div>
@endforeach
</x-layout>
