<ul class="list-group">
    @foreach ($sections as $section)
        <li class="list-group-item list-group-item-action">
            <a class="nav-link active" aria-current="page" href="{{ route("admin.$section.index") }}">{{ $section }}</a>
        </li>
    @endforeach
</ul>
