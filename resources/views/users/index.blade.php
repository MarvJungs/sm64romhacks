<x-layout>
    <h1>Users</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Username</th>
            <th>ID</th>
            <th>Roles</th>
            <th>Country</th>
            <th>Gender</th>
            <th>Created at</th>
            <th>Last Modified at</th>
        </thead>
        @foreach ($users as $user)
            <tbody>
                <tr>
                    <td>
                        <img src="{{ $user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="32"
                            width="32" />
                        <a href="{{ route('users.show', ['user' => $user]) }}">
                            {{ $user->global_name }}
                        </a>
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if (!is_null($user->getRoles()))
                            <ul>
                                @foreach ($user->getRoles() as $guildMemberRole)
                                    <li>{{ $roles[$guildMemberRole] }}</li>
                                @endforeach
                            </ul>
                        @else
                            Unknown
                        @endif
                    </td>
                    <td><span class="fi fi-{{ strtolower($user->country) }} w-100 h-auto"></span></td>
                    <td>{{ $user->gender }}</td>
                    <td>
                        <span class="time">
                            {{ $user->created_at }}
                        </span>
                    </td>
                    <td>
                        <span class="time">
                            {{ $user->updated_at }}
                        </span>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
</x-layout>
