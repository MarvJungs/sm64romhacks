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
    <span class="text-muted text-nowrap">Downloads: {{ $version->downloadcount }} |
        {{ round(Storage::size($version->filename) / 1048576, 2) }}
        MB
    </span>
</td>
<td>{!! $version->getAuthorList() !!}</td>
<td>{{ $version->starcount }}</td>
<td>{{ $version->releasedate }}</td>
@if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isSiteHelper()))
    <td class="d-flex gap-3 justify-content-between">
        <a href="{{ route('version.edit', [$version->hack, $version]) }}" class="btn btn-primary">
            <span class="fa-solid fa-pen"></span>
        </a>
        <form action="{{ route('version.destroy', [$version->hack, $version]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">
                <span class="fa-solid fa-trash"></span>
            </button>
        </form>
    </td>
@endif
</tr>
