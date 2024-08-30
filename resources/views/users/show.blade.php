<x-layout>
    <h2>
        <img src="{{ $user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="64" width="64" />
        {{ $user->global_name }}

        @if (isset($user->country))
            <span class="fi fi-{{ strtolower($user->country) }}"></span>
        @endif

        @if (isset($user->gender))
            ({{ $user->gender }})
        @endif

        <a class="btn btn-primary btn-floating m-1" href="/profile/edit" role="button"><span
                class="fa-solid fa-pencil fa-fw"></span></a>
    </h2>
    <hr class="mb-5" />
    <section class="mb-5">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($versions as $version)
                        <tr>
                            <td>{{ $version->hack->name }}</td>
                            <td>{{ $version->name }}</td>
                            <td>{{ $version->starcount }}</td>
                            <td>{{ $version->releasedate }}</td>
                            <td class="text-muted">Downloads: {{ $version->downloadcount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <em>This user has not released any hacks yet.</em>
        @endif
    </section>
    <section>
        <h1>Comments</h1>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <div class="card mb-3">
                    <h3 class="card-header">
                        <a href="{{ route('hacks.show', ['hack' => $comment->hack]) }}">
                            {{ $comment->hack->name }}
                        </a>
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
                            Written at
                            <span class="time">
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
