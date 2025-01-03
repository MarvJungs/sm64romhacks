<x-layout>
    <h2>
        <img src="{{ $user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="64" width="64" />
        {{ $user->global_name }}

        @if (isset($user->country))
            <span class="fi fi-{{ strtolower($user->country) }}"></span>
        @endif

        <a class="btn btn-primary btn-floating m-1" href="/profile/edit" role="button"><span
                class="fa-solid fa-pencil fa-fw"></span></a>
    </h2>
    @if (isset($user->gender))
        <sup>({{ $user->gender }})</sup>
        <br />
    @endif
    <em>
        Roles:
        @if (!is_null($guildMemberRoles) && !empty($guildMemberRoles))
            <ul>
                @foreach ($guildMemberRoles as $guildMemberRole)
                    <li>{{ $roles[$guildMemberRole] }}</li>
                @endforeach
            </ul>
        @else
            None
        @endif
    </em>
    <hr class="mb-5" />
    <section class="mb-4">
        <h1>Released Hacks</h1>
        @if ($versions)
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Hackname</th>
                        <th>Version</th>
                        <th>Starcount</th>
                        <th>Release Date</th>
                        <th>Downloads</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($versions as $version)
                        <tr>
                            <td>
                                <a href="{{ route('hacks.show', $version->hack) }}">
                                    {{ $version->hack->name }}
                                </a>
                            </td>
                            <td>{{ $version->name }}</td>
                            <td>{{ $version->starcount }}</td>
                            <td>{{ $version->releasedate }}</td>
                            <td class="text-muted">Downloads: {{ $version->downloadcount }}</td>
                            <td class="d-flex justify-content-around">
                                <a class="btn btn-primary"
                                    href="{{ route('version.edit', ['hack' => $version->hack, 'version' => $version]) }}">
                                    <span class="fa-solid fa-pen"></span>
                                </a>
                                <form
                                    action="{{ route('version.destroy', ['hack' => $version->hack, 'version' => $version]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        <span class="fa-solid fa-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <em>You have not released any hacks.</em>
        @endif
    </section>
    <section>
        <h1>Comments</h1>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <div class="card mb-3">
                    <h3 class="card-header d-flex justify-content-between">
                        <a href="{{ route('hacks.show', $comment->hack) }}">
                            {{ $comment->hack->name }}
                        </a>
                        <form action="{{ route('comments.destroy', $comment) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <span class="fa-solid fa-trash"></span>
                            </button>
                        </form>
                    </h3>
                    <div class="card-body">
                        <h4 class="card-title">
                            {{ $comment->title }}
                        </h4>
                        <p class="card-text">
                            {!! $comment->text !!}
                        </p>
                    </div>
                    <div class="card-footer">
                        <span class="text-secondary">
                            Written at <span class="time">
                                {{ $comment->created_at }}
                            </span>
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <em>This user has not written any comments.</em>
        @endif
    </section>
</x-layout>
