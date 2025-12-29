<div class="card mb-5">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4>{{ $newspost->title }}</h4>
            <div>
                @can('view', $newspost)
                    <a class="btn btn-primary text-decoration-none"
                        href="{{ route('newspost.show', ['newspost' => $newspost]) }}" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="View Newspost"><x-bi-eye /></a>
                @endcan
                @can('update', $newspost)
                    <a class="btn btn-info text-decoration-none"
                        href="{{ route('newspost.edit', ['newspost' => $newspost]) }}" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Edit Newspost"><x-bi-pencil /></a>
                @endcan
                @can('delete', $newspost)
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Newspost">
                        <button class="btn btn-danger text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#modal-confirm"
                            data-bs-route="{{ route('newspost.destroy', ['newspost' => $newspost]) }}"
                            data-bs-method="DELETE"><x-bi-trash /></button>
                    </span>
                @endcan
            </div>
        </div>
        <p class="text-info">
            Written By
            @if ($newspost->user)
                <img src="{{ Storage::url($newspost->user->avatar) }}" height="32" width="32" />
                <a href="{{ route('users.show', ['user' => $user]) }}">{{ $newspost->user->name }}</a>
            @else
                Deleted User
            @endif
            at <span class="time">{{ $newspost->created_at }}</span> (last
            updated at <span class="time">{{ $newspost->updated_at }}</span>)
        </p>
    </div>
    <div class="card-body">
        <div class="card-text">
            <x-editor-js :blocks="$newspost->text['blocks']" />
        </div>
    </div>
</div>
