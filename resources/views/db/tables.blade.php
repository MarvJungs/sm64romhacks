<x-layout>
    <ul>
    @foreach ($tables as $table)
        <li><a href="/tables/{{$table['name']}}">{{$table['name']}}</a></li>
    @endforeach
    </ul>
</x-layout>