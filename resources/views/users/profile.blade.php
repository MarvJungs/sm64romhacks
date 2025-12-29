<x-layout>
    <section class="d-flex flex-row gap-4 mb-5" id="header">
        <img src="{{ Storage::url($user->avatar) }}" style="max-height: 128px" />
        <div class="d-flex flex-column">
            <h1>{{ $user->country?->emoji }} {{ $user->name }}</h1>
            <p>Roles:
                @if ($user->roles->count() > 0)
                    @foreach ($user->roles as $role)
                        <span class="badge text-bg-secondary">{{ $role->name }}</span>
                    @endforeach
                @else
                    None
                @endif
            </p>
            @if ($user->description)
                <div class="alert alert-light">
                    <p class="line-break">{{ $user->description }}</p>
                </div>
            @endif
        </div>
    </section>
    <section>
        <h1 class="text-decoration-underline">Created Rom Hacks</h1>
        @if ($author)
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Hack</th>
                        <th>Version</th>
                        <th>Downloadlink</th>
                        <th>Starcount</th>
                        <th>Releasedate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($author->versions as $version)
                        <tr>
                            <td><a
                                    href="{{ route('hack.show', ['hack' => $version->romhack]) }}">{{ $version->romhack->name }}</a>
                            </td>
                            <td>{{ $version->name }}</td>
                            <td>
                                <a href="{{ route('version.download', ['version' => $version]) }}">Download</a> | <a
                                    href="/patcher?id={{ $version->id }}">Patch File</a>
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
        @else
            <p>This user does not have yet created any Rom Hacks.</p>
        @endif
    </section>
    <hr />
    <section>
        <h1 class="text-decoration-underline">Created Comments</h1>
        @if ($user->comments->count() > 0)
            @foreach ($user->comments as $comment)
                <x-romhack-comment :comment="$comment" />
            @endforeach
        @else
            <p>This user has not written any Comments.</p>
        @endif
    </section>
    <hr />
</x-layout>
