<x-layout>
    <h1 class="text-center text-decoration-underline">
        {{ $hack->name }}
        @if (Auth::check() && Auth::user()->hasRole('Admin'))
            <a href="{{ route('version.create', ['hack' => $hack]) }}" class="btn btn-info">
                <img src={{ asset('images/icons/plus.svg') }} />
                Create Version
            </a>
            <a href="{{ route('hack.manage', ['hack' => $hack]) }}" class="btn btn-secondary">
                <img src={{ asset('images/icons/edit.svg') }} />
                Edit Hack
            </a>
        @endif
    </h1>
    <section id="description">
        @if (!is_null($hack->description))
            <x-editor-js :blocks="json_decode($hack->description, true)['blocks']" />
        @endif
    </section>
    <table class="table table-hover table-responsive table-bordered">
        <thead>
            <tr>
                <th>Hackname</th>
                <th>Hackversion</th>
                <th>Authors</th>
                <th>Downloadlink</th>
                <th>Starcount</th>
                <th>Releasedate</th>
                @if (Auth::check() && Auth::user()->hasRole('Admin'))
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($hack->versions->sortByDesc('downloadcount') as $version)
                <tr>
                    <td>
                        <a href="/hacks/{{ $hack->slug }}">{{ $hack->name }}</a>
                    </td>
                    <td>{{ $version->name }}</td>
                    <td>{{ $version->authors->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="/hacks/download/{{ $version->id }}">Download</a> |
                        <a href="/patcher?id={{ $version->id }}">Patch File</a>
                        <br />
                        <span class="text-muted">
                            Downloads: {{ $version->downloadcount }} |
                            File Size: {{ round(Storage::size($version->filename) / 1048576, 2) }} MB
                        </span>
                    </td>
                    <td>{{ $version->starcount }}</td>
                    <td>{{ $version->releasedate }}</td>
                    @if (Auth::check() && Auth::user()->hasRole('Admin'))
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('version.edit', ['hack' => $hack, 'version' => $version]) }}"
                                    class="btn btn-info"><img src={{ asset('images/icons/edit.svg') }} /></a>
                                <a href="{{ route('version.delete', ['hack' => $hack, 'version' => $version]) }}"
                                    class="btn btn-danger"><img src={{ asset('images/icons/delete.svg') }} /></a>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr />
    @auth
        <h2>Add A Comment</h2>
        <form method="post" action="{{ route('comment.create', ['hack' => $hack]) }}">
            @csrf
            <textarea class="form-control mb-2" name="text" rows="5"></textarea>
            <button class="btn btn-primary" type="submit">Post Comment</button>
        </form>
        <hr />
    @endauth

    <section id="comments">
        <h1 class="text-decoration-underline" id="comments">Comments</h1>
        @if ($hack->comments->count() > 0)
            @foreach ($hack->comments->sortByDesc('created_at') as $comment)
                <div class="card mb-3" id="{{ $comment->id }}">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <img src="/storage/{{ $comment->user->avatar }}" height="32" width="32" />
                                <a href="">{{ $comment->user->name }}</a>
                            </div>
                            @auth
                                <div>
                                    @if (Auth::user()->isAuthorOf($comment))
                                        <a href="{{ route('comment.delete', ['comment' => $comment]) }}" class="btn btn-danger">
                                            <img src={{ asset('images/icons/delete.svg') }} />
                                        </a>
                                    @endif
                                    <form class="d-inline" method="post"
                                        action="{{ route('comment.like', ['comment' => $comment]) }}">
                                        @csrf
                                        <button class="btn btn-success" type="submit">
                                            @if (Auth::user()->hasLikedComment($comment))
                                                '<img src={{ asset('images/icons/hand-thumbs-up-fill.svg') }} />
                                            @else
                                                <img src={{ asset('images/icons/hand-thumbs-up.svg') }} />
                                            @endif
                                            {{ $comment->ratings->where('rating', 1)->count() }}
                                        </button>
                                    </form>
                                    <form class="d-inline" method="post"
                                        action="{{ route('comment.dislike', ['comment' => $comment]) }}">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">
                                            @if (Auth::user()->hasDislikedComment($comment))
                                                <img src={{ asset('images/icons/hand-thumbs-down-fill.svg') }} />
                                            @else
                                                <img src={{ asset('images/icons/hand-thumbs-down.svg') }} />
                                            @endif
                                            {{ $comment->ratings->where('rating', -1)->count() }}
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach (explode(PHP_EOL, $comment->text) as $line)
                            {{ $line }}<br />
                        @endforeach
                    </div>
                    <div class="card-footer">
                        Posted at <span class="time">{{ $comment->created_at }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <p>There are no comments for this hack. Be the first one to leave one :) (must be logged in for this)</p>
        @endif
    </section>
</x-layout>
