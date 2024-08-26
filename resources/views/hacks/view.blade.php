<x-layout>
    <h1 class="text-center text-decoration-underline">{{ $hack->name }}</h1>

    <table class="table">
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
            @foreach ($hack->versions as $version)
                <tr>
                    <td>{{ $hack->name }}</td>
                    <td>{{ $version->name }}</td>
                    <td>
                        <a href="/hacks/download/{{ $version->id }}">Download</a> |
                        <a href="/patcher?id={{ $version->id }}">Patch File</a> <br />
                        <span class="text-muted">Downloads: {{ $version->downloadcount }} |
                            {{ round(Storage::size($version->filename) / 1048576, 2) }}
                            MB
                        </span>
                    </td>
                    <td>{{ implode(', ', $version->authors()->pluck('name')->toArray()) }}</td>
                    <td>{{ $version->starcount }}</td>
                    <td>{{ $version->releasedate }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($hack->description)
        <div class="card">
            <div class="card-body">
                @foreach (json_decode($hack->description) as $item)
                    {!! parseEditorText($item) !!}
                @endforeach
            </div>
        </div>
    @endif

    <div class="container w-50 d-flex justify-content-center">
        <div class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($hack->images as $image)
                    <div class="carousel-item active flex-column " data-bs-interval="2500">
                        <img src="{{ Storage::url($image->filename) }}" class="d-block w-100"
                            {{ getimagesize('storage/' . $image->filename)[3] }}>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <hr />

    @if (Auth::check())
        <div class="accordion mb-4" id="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#addComment" aria-expanded="false" aria-controls="addComment">
                        Add Comment
                    </button>
                </h2>
                <div id="addComment" class="accordion-collapse collapse" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <form action="/comments" method="post">
                            @csrf
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <label for="title">Title</label>
                            <input class="form-control mb-4" type="text" name="title" id="title" required>

                            <label for="text">Comment</label>
                            <textarea class="form-control mb-4" name="text" id="text" cols="15" rows="10" required></textarea>

                            <button class="btn btn-primary w-100 mb-4" type="submit">Save Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="comments">
        <h2>Comments</h2>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <div class="card mb-4">
                    <header class="card-header">
                        <a href="/users/{{ $comment->user->id }}">
                            @if ($comment->user->country)
                                <span class="fi fi-{{ strtolower($comment->user->country) }}"></span>
                            @endif
                            {{ $comment->user->display_name }}
                            @if ($comment->user->gender)
                                ({{ $comment->user->gender }})
                            @endif
                        </a>
                    </header>
                    <div class="card-body">
                        <h2 class="card-title">{{ $comment->title }}</h2>
                        <hr />
                        <p class="card-text">{!! nl2br(htmlspecialchars($comment->text)) !!}</p>
                    </div>
                    <footer class="card-footer text-body-secondary">
                        Created at <span class="time">
                            {{ $comment->created_at }}
                        </span>
                    </footer>
                </div>
            @endforeach
        @else
            <em>No Comments found</em>
        @endif
    </div>
</x-layout>
