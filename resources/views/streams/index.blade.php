<x-layout>
    <div class="streams">
        @if (sizeof($streams) == 0)
            <p>Nobody is currently streaming!</p>
        @endif
        @foreach ($streams as $stream)
            <div class="stream-container">
                <a href="https://www.twitch.tv/{{$stream->user_login}}" target="_blank">
                    <img src="{{str_replace('{height}', 720, str_replace('{width}', 1280, $stream->thumbnail_url))}}">
                </a>
                <h2>{{$stream->title}}</h2>
                <h2>{{$stream->user_name}} ({{$stream->viewer_count}} viewers)</h2>
            </div>  
        @endforeach
    </div>
</x-layout>