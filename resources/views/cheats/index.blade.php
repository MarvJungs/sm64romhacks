<x-layout>
    <div class="justify-content-center">
        <h4 class="text-decoration-underline">Table Of Contents</h4>
        <ol>
            @foreach ($cheats as $cheat)
                <li><a href="#{{ Str::slug($cheat->title) }}">{{ $cheat->title }}</a></li>
            @endforeach
        </ol>
        <hr />
    </div>
    @foreach ($cheats as $cheat)
        <div class="row">
            <div class="col">
                <h2 class="text-decoration-underline">{{ $cheat->title }}</h2>
            </div>
            <div class="col">
                <button type="button" data-bs-toggle="tooltip" title="Copy Cheatcode" class="btn btn-primary" onclick="copyCheat('{{ Str::slug($cheat->title) }}')"><span class="fa-solid fa-link"></span></button><br />
            </div>
        </div>
        @isset($cheat->description)
            <h3>Description</h3>
            @foreach (json_decode($cheat->description) as $item)
                {!! parseEditorText($item) !!}
            @endforeach
        @endisset
        <h3>Cheat Code</h3>
        <div id={{ Str::slug($cheat->title) }}>
            @foreach (json_decode($cheat->code) as $item)
                {!! parseEditorText($item) !!}
            @endforeach
        </div>
        <hr />
    @endforeach

    <script type="text/javascript">
        function copyCheat(id) {
            const element = document.getElementById(id);
            navigator.clipboard.writeText(element.innerText);
        }
    </script>
</x-layout>
