<x-layout>
    <section id="news" class="mb-4">
        <h1>Latest News</h1>
        @if (sizeof($news) > 0)
            @foreach ($news as $message)
                <div class="card mb-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mt-2">
                            @if (filter_var($message->important, FILTER_VALIDATE_BOOLEAN))
                                <span class="text-danger">!!!</span>
                            @endif
                            {{ $message->title }}
                        </h4>
                        @if (Auth::check() && Auth::user()->global_name == $message->user->global_name)
                            <div class="d-flex gap-3">
                                <a class="btn btn-primary" href="/news/{{ $message->id }}/edit">
                                    <span class="fa-solid fa-pen"></span>
                                    Edit News Post
                                </a>
                                <form class="d-inline-flex" action="/news/{{ $message->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        <span class="fa-solid fa-trash"></span>
                                        Delete News Post
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @foreach (json_decode($message->text) as $item)
                            {!! parseEditorText($item) !!}
                        @endforeach
                    </div>
                    <div class="card-footer">
                        Written By
                        <img src="{{ $message->user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="24" width="24">
                        {{ $message->user->global_name }}
                        @if ($message->user->gender)
                            <sup class="text-muted">({{ $message->user->gender }})</sup>
                        @endif
                        @if ($message->user->country)
                            <span class="fi fi-{{ strtolower($message->user->country) }}"></span>
                        @endif
                        on <span class="time">
                            {{ $message->created_at }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <em>No News found</em>
        @endif
    </section>
    <section id="versions" class="mb-4">
        <h1>Latest Added Versions</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Hack Name</th>
                    <th scope="col">Hack Version</th>
                    <th scope="col">Download Link</th>
                    <th scope="col">Creator</th>
                    <th scope="col">Starcount</th>
                    <th scope="col">Release Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($versions as $version)
                    <tr>
                        <td>
                            <a href="/hacks/{{ $version->hack->id }}">
                                {{ $version->hack->name }}
                            </a>
                        </td>
                        <td>{{ $version->name }}</td>
                        <td>
                            <a href="/hacks/download/{{ $version->id }}">Download</a>
                            <span class="text-muted">({{ round(Storage::size($version->filename) / 1048576, 2) }}
                                MB)</span><br />
                            <span class="text-muted">Downloads: {{ $version->downloadcount }}</span><br />
                        </td>
                        <td>{{ implode(', ', $version->authors()->pluck('name')->toArray()) }}</td>
                        <td>{{ $version->starcount }}</td>
                        <td>{{ $version->releasedate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <section id="comments" class="mb-4">
        <h1>Latest Comments Added</h1>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <div class="card mb-4">
                    <header class="card-header">
                        <a href="/hacks/{{ $comment->hack->id }}">
                            <h5>{{ $comment->hack->name }}</h5>
                        </a>
                    </header>
                    <div class="card-body">
                        <h2 class="card-title">{{ $comment->title }}</h2>
                        <hr />
                        <p class="card-text">{!! nl2br(htmlspecialchars($comment->text)) !!}</p>
                    </div>
                    <footer class="card-footer text-body-secondary">
                        Created at
                        <span class="time">
                            {{ $comment->created_at }}
                        </span>
                        by 
                        <a href="/users/{{ $comment->user->id }}">
                            @if ($comment->user->country)
                                <span class="fi fi-{{ strtolower($comment->user->country) }}"></span>
                            @endif
                            {{ $comment->user->global_name }}
                            @if ($comment->user->gender)
                                ({{ $comment->user->gender }})
                            @endif
                        </a>
                    </footer>
                </div>
            @endforeach
        @else
            <em>No Comments found</em>
        @endif
    </section>
</x-layout>
