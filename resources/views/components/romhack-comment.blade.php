<div class="card mb-3" id="{{ $comment->id }}">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            @if ($comment->user)
                <div class="col-md-auto">
                    <img class="m-2" src="/storage/{{ $comment->user?->avatar }}" height="64" width="64" />
                </div>
                <div class="col">
                    <a
                        href="{{ route('users.show', ['user' => $comment->user]) }}">{{ $comment->user?->name }}</a><br />
                @else
                    <div class="col">
                        <span class="text-muted">Deleted User</span><br />
            @endif
            Posted at <span class="time">{{ $comment->created_at }}</span>
        </div>
        <div>
            @can('delete', $comment)
                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Comment">
                    <button data-bs-toggle="modal" data-bs-target="#modal-confirm"
                        data-bs-route="{{ route('comment.destroy', ['comment' => $comment]) }}" data-bs-method="DELETE"
                        class="btn btn-danger">
                        <x-bi-trash />
                    </button>
                </span>
            @endcan

            @can('rate', $comment)
                <form class="d-inline" method="post" action="{{ route('comment.like', ['comment' => $comment]) }}">
                    @csrf
                    @if (Auth::user()->hasLikedComment($comment))
                        <button class="btn btn-success" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="Unlike">
                            <x-bi-hand-thumbs-up-fill />
                        @else
                            <button class="btn btn-success" type="submit" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-title="Like">
                                <x-bi-hand-thumbs-up />
                    @endif
                    {{ $comment->ratings->where('rating', 1)->count() }}
                    </button>
                </form>
                <form class="d-inline" method="post" action="{{ route('comment.dislike', ['comment' => $comment]) }}">
                    @csrf
                    @if (Auth::user()->hasDislikedComment($comment))
                        <button class="btn btn-danger" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="Undislike">
                            <x-bi-hand-thumbs-down-fill />
                        @else
                            <button class="btn btn-danger" type="submit" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-title="Dislike">
                                <x-bi-hand-thumbs-down />
                    @endif
                    {{ $comment->ratings->where('rating', -1)->count() }}
                    </button>
                </form>
            @endcan

            @cannot('rate', $comment)
                <button class="btn btn-success pe-none" disabled>
                    <x-bi-hand-thumbs-up />
                    {{ $comment->ratings->where('rating', 1)->count() }}
                </button>
                <button class="btn btn-danger pe-none" disabled>
                    <x-bi-hand-thumbs-down />
                    {{ $comment->ratings->where('rating', -1)->count() }}
                </button>
            @endcannot
        </div>
    </div>
</div>
<div class="card-body">
    @foreach (explode(PHP_EOL, $comment->text) as $line)
        {{ $line }}<br />
    @endforeach
</div>
<div class="card-footer">
    Romhack: <a href="{{ route('hack.show', ['hack' => $comment->romhack]) }}">{{ $comment->romhack->name }}</a>
</div>
</div>
