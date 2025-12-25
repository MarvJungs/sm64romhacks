<x-layout>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-decoration-underline">Roles</h1>
        <div>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-success" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Create Role">
                <x-bi-plus-circle />
            </a>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Priority</th>
                <th>Users</th>
                <th>created at</th>
                <th>updated at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->priority }}</td>
                    <td>{{ $role->users->count() }}</td>
                    <td class="time">{{ $role->created_at }}</td>
                    <td class="time">{{ $role->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('admin.roles.edit', ['role' => $role]) }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Role">
                            <x-bi-pencil />
                        </a>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Role">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                data-bs-route="{{ route('admin.roles.destroy', ['role' => $role]) }}"
                                data-bs-method="DELETE">
                                <x-bi-trash />
                            </button>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
