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
                <form class="d-inline-flex" action="{{ route('news.destroy', $message) }}" method="post">
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
        <a href="{{ route('users.show', $message->user) }}">
            {{ $message->user->global_name }}
        </a>
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
