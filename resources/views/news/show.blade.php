<x-layout>
    <div class="card mb-5">
        <div class="card-header">
            <h4>
                {{ $news->title }}
            </h4>
        </div>
        <div class="card-body">
            @foreach (json_decode($news->text) as $item)
                {!! parseEditorText($item) !!}
            @endforeach
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div>
                Written By 
                <img src="{{ $news->user->avatar }}" height="24" width="24">
                {{ $news->user->display_name }}
                @if ($news->user->gender)
                    <sup class="text-muted">({{ $news->user->gender }})</sup>
                @endif
                @if ($news->user->country)
                    <span class="fi fi-{{ strtolower($news->user->country) }}"></span>
                @endif
                on {{ $news->created_at }}
            </div>
            <div>
                <a class="btn btn-primary" href="/news">
                    Back To Main
                </a>
            </div>
        </div>
    </div>
</x-layout>
