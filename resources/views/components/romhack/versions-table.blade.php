<table class="table table-hover table-responsive table-bordered">
    <thead>
        <tr>
            <th>
                Hackversion
                @can('createVersion', $hack)
                    <a href="{{ route('version.create', ['hack' => $hack]) }}" class="btn btn-success" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Add new Version">
                        <x-bi-plus />
                    </a>
                @endcan
            </th>
            <th>Authors</th>
            <th>Downloadlink</th>
            <th>Starcount</th>
            <th>Releasedate</th>
            @can('update', $hack)
                <th>Actions</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($hack->versions->sortByDesc('downloadcount') as $version)
            <tr>
                <td>
                    @if ($version->demo)
                        <x-bi-files-alt data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Demo" />
                    @endif
                    @if ($version->recommened)
                        <x-bi-star-fill data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Recommened" />
                    @endif
                    {{ $version->name }}
                </td>
                <td>{{ $version->authors->pluck('name')->join(', ') }}</td>
                <td>
                    <a href="{{ route('version.download', ['version' => $version]) }}">Download</a> |
                    <a href="{{ route('tools.patcher', ['id' => $version->id]) }}">Patch File</a>
                    <br />
                    <span class="text-muted">
                        Downloads: {{ $version->downloadcount }} |
                        File Size: {{ round(Storage::size($version->filename) / 1048576, 2) }} MB
                    </span>
                </td>
                <td>{{ $version->starcount }}</td>
                <td>{{ $version->releasedate }}</td>
                @can('update', $hack)
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('version.edit', ['hack' => $hack, 'version' => $version]) }}"
                                class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit Version"><x-bi-pencil /></a>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Version">
                                <button data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                    data-bs-route="{{ route('version.destroy', ['hack' => $hack, 'version' => $version]) }}"
                                    data-bs-method="DELETE" class="btn btn-danger"><x-bi-trash /></button>
                            </span>
                        </div>
                    </td>
                @endcan
            </tr>
        @endforeach
    </tbody>
</table>
