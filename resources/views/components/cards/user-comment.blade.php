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
            <img src="{{ $comment->user->getAvatar() }}" width="32" height="32" />
            <a href="{{ route('users.show', $comment->user) }}">
                {{ $comment->user->global_name }}
            </a>
            @if ($comment->user->country)
                <span class="fi fi-{{ strtolower($comment->user->country) }}"></span>
            @endif
            @if ($comment->user->gender)
                <sup>({{ $comment->user->gender }})</sup>
            @endif
        @else
            <em>Unknown User</em>
        @endif
    </footer>
</div>
