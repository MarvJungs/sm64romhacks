<x-layout>
    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Amount Hacks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td class="time">{{ $tag->created_at }}</td>
                    <td class="time">{{ $tag->updated_at }}</td>
                    <td><abbr
                            title="{{ $tag->romhacks->pluck('name')->join(', ') }}">{{ $tag->romhacks->count() }}</abbr>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a class="btn btn-primary" href="{{ route('admin.romhacktags.edit', ['tag' => $tag]) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Edit Tag"><x-bi-pencil /></a>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Tag">
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm"
                                    data-bs-route="{{ route('admin.romhacktags.destroy', ['tag' => $tag]) }}"
                                    data-bs-method="DELETE"><x-bi-trash /></button>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
