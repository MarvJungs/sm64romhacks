<x-layout>
    <h1>Comments</h1>
    @foreach ($comments as $comment)
        <div class="card mb-4">
            <div class="card-header">
                <form action="/comments/{{ $comment->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <h2>
                        <a href="/hacks/{{ $comment->hack->id }}">
                            {{ $comment->hack->name }}
                        </a>
                        <button class="btn btn-danger" type="submit">
                            <span class="fa-solid fa-trash"></span>
                        </button>
                    </h2>
                </form>
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ $comment->title }}</h3>
                <hr />
                <p class="card-text">{!! $comment->text !!}</p>
            </div>
            <div class="card-footer">
                Created by
                @if ($comment->user->country)
                    <span class="fi fi-{{ strtolower($comment->user->country) }}"></span>
                @endif
                <a href='/users/{{ $comment->user->id }}'>
                    {{ $comment->user->display_name }}
                </a>
                @if ($comment->user->gender)
                    <span class="text-secondary">({{ $comment->user->gender }})</span>
                @endif
                at <span class="time">
                    {{ $comment->created_at }}
                </span>
            </div>
        </div>
    @endforeach
</x-layout>
