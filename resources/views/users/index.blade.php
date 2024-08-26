<x-layout>
    <h1>Users</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Username</th>
            <th>ID</th>
            <th>Role</th>
            <th>Country</th>
            <th>Gender</th>
            <th>Created at</th>
            <th>Last Modified at</th>
        </thead>
        @foreach ($users as $user)
            <tbody>
                <tr>
                    <td>
                        <img src="{{ $user->getAvatar(['extension' => 'png', 'size' => 256]) }}" height="32" width="32"/>
                        <a href="/users/{{ $user->id }}">
                            {{ $user->global_name }}
                        </a>
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td><span class="fi fi-{{ strtolower($user->country) }} w-100 h-auto"></span></td>
                    <td>{{ $user->gender }}</td>
                    <td>
                        <span class="time">
                            {{ $user->created_at }}
                        </span>
                    </td>
                    <td>{{ $user->updated_at }}</td>
                </tr>
            </tbody>
        @endforeach
    </table>
</x-layout>
