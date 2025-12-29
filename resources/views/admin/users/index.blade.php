<x-layout>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Country</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td>{{ $user->country?->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete User">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                data-bs-route="{{ route('admin.users.destroy', ['user' => $user]) }}"
                                data-bs-method="DELETE">
                                <x-bi-trash />
                            </button>
                        </span>
                        <a href="{{ route('admin.users.roles', ['user' => $user]) }}" class="btn btn-secondary"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Set Roles">
                            <x-bi-person-fill-up />
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</x-layout>
