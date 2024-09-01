<div class="card mb-4">
    <header class="card-header">
        <a href="{{ route('hacks.show', $comment->hack) }}">
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
        @if (!is_null($comment->user))
        <a href="{{ route('users.show', $comment->user) }}">
            @if ($comment->user->country)
                <span class="fi fi-{{ strtolower($comment->user->country) }}"></span>
            @endif
            {{ $comment->user->global_name }}
            @if ($comment->user->gender)
                ({{ $comment->user->gender }})
            @endif
        </a>
        @else
        <em>Unknown User</em>
        @endif
    </footer>
</div>