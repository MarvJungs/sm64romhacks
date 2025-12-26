<x-layout>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>User</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->user->name ?? '???' }}</td>
                    <td class="d-flex gap-3">
                        <a href="{{ route('admin.authors.edit', ['author' => $author]) }}" class="btn btn-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Author">
                            <x-bi-pencil />
                        </a>
                        <a href="{{ route('admin.authors.setUser', ['author' => $author]) }}" class="btn btn-info"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Set User">
                            <x-bi-person-fill-up />
                        </a>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Author">
                            <button data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                data-bs-route="{{ route('admin.authors.destroy', ['author' => $author]) }}"
                                class="btn btn-danger" data-bs-method="DELETE">
                                <x-bi-trash />
                            </button>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $authors->links() }}
</x-layout>
