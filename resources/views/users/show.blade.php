<x-layout>
    <h2>
        <img src="{{ $user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="64" width="64" />
        {{ $user->global_name }}

        @if (isset($user->country))
            <span class="fi fi-{{ strtolower($user->country) }}"></span>
        @endif
        @if (Auth::check() && Auth::user()->id == $user->id)
            <a class="btn btn-primary btn-floating m-1" href="/profile/edit" role="button"><span
                    class="fa-solid fa-pencil fa-fw"></span></a>
        @endif
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
