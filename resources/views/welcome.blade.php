<x-layout>
    <h1>Recent Posted Newsposts</h1>
    @foreach ($newsposts as $newspost)
        <x-newspost-component :newspost="$newspost" />
    @endforeach
    <hr />

    <h1>Recent Added Patchfiles</h1>
    <table class="table table-hover table-responsive table-bordered">
        <thead>
            <tr>
                <th>Hack</th>
                <th>Hackversion</th>
                <th>Authors</th>
                <th>Downloadlink</th>
                <th>Starcount</th>
                <th>Releasedate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($versions as $version)
                <tr>
                    <td>
                        <a href="{{ route('hack.show', ['hack' => $version->romhack]) }}">{{ $version->romhack->name }}</a>
                    </td>
                    <td>{{ $version->name }}</td>
                    <td>{{ $version->authors->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('version.download', ['version' => $version]) }}">Download</a> |
                        <a href="/patcher?id={{ $version->id }}">Patch File</a>
                        <br />
                        <span class="text-muted">
                            Downloads: {{ $version->downloadcount }} |
                            File Size: {{ round(Storage::size($version->filename) / 1048576, 2) }} MB
                        </span>
                    </td>
                    <td>{{ $version->starcount }}</td>
                    <td>{{ $version->releasedate }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr />

    <h1>Recent Posted Comments</h1>
    @foreach ($comments as $comment)
        <x-romhack-comment :comment="$comment" />
    @endforeach

</x-layout>
