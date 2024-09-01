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
            <x-table.versions.table :versions="$versions" />
        @else
            <em>This user has not released any hacks yet.</em>
        @endif
    </section>
    <section>
        <h1>Comments</h1>
        @if (sizeof($comments) > 0)
            @foreach ($comments as $comment)
                <x-cards.user-comment :comment="$comment" />
            @endforeach
        @else
            <em>This user has not written any comments.</em>
        @endif
    </section>
</x-layout>
