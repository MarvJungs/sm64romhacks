<x-layout>
    <div class="d-flex justify-content-between mb-4">
        <h1>News</h1>
        @if (Auth::check() && Auth::user()->role->priority <= 2)
            <a href="/news/create" class="align-self-center btn btn-success">
                <span class="fa-solid fa-plus"></span>
                Create New Newspost
            </a>
        @endif
    </div>
    @foreach ($news as $message)
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mt-2">
                    @if (filter_var($message->important, FILTER_VALIDATE_BOOLEAN))
                        <span class="text-danger">!!!</span>
                    @endif
                    {{ $message->title }}
                </h4>
                @if (Auth::check() && Auth::user()->display_name == $message->user->display_name)
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
                <img src="{{ $message->user->avatar }}" height="24" width="24">
                {{ $message->user->display_name }}
                @if ($message->user->gender)
                    <sup class="text-muted">({{ $message->user->gender }})</sup>
                @endif
                @if ($message->user->country)
                    <span class="fi fi-{{ strtolower($message->user->country) }}"></span>
                @endif
                on {{ $message->created_at }}
            </div>
        </div>
    @endforeach
</x-layout>
