@if ($version->recommened)
    <tr class="table-active">
    @else
    <tr>
@endif
<td>
    <a href="{{ route('hacks.show', $version->hack) }}">
        {{ $version->hack->name }}
    </a>
</td>
<td>{{ $version->name }}</td>
<td>
    <a href="{{ route('hack.download', $version) }}">Download</a> |
    <a href="{{ route('patcher.index', ['id' => $version->id]) }}">Patch File</a> <br />
    <span class="text-muted">Downloads: {{ $version->downloadcount }} |
        {{ round(Storage::size($version->filename) / 1048576, 2) }}
        MB
    </span>
</td>
<td>{!! $version->getAuthorList() !!}</td>
<td>{{ $version->starcount }}</td>
<td>{{ $version->releasedate }}</td>
</tr>
