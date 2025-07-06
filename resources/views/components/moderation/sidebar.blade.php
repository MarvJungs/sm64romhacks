    <ul class="list-group">
        @foreach ($tables as $table)
            <li class="list-group-item list-group-item-action">
                <a class="nav-link active" aria-current="page" href="moderation/{{$table['name']}}">{{$table['name']}}</a>
            </li>
        @endforeach
    </ul>
