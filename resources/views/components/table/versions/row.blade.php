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
@if (Auth::check() &&
        (Auth::user()->isAuthorOfVersion($version) ||
            Auth::user()->isAdmin() ||
            Auth::user()->isModerator() ||
            Auth::user()->isSiteHelper()))
    <td class="d-flex flex-row gap-2 justify-content-around p-2">
        <a href="{{ route('version.edit', [$version->hack, $version]) }}" class="btn btn-primary">
            <span class="fa-solid fa-pen"></span>
            Edit Version
        </a>
        <form action="{{ route('version.destroy', [$version->hack, $version]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">
                <span class="fa-solid fa-trash"></span>
                Delete Version
            </button>
        </form>
    </td>
@endif
</tr>
