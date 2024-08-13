<x-layout>
    <h2>
        <img src="{{ $user->avatar }}" height="64" width="64" />
        {{ $user->display_name }}

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

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Hackname</th>
                <th>Version</th>
                <th>Starcount</th>
                <th>Release Date</th>
                <th>Downloads</th>
                <th>Actions</th>
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
                    <td class="d-flex justify-content-around">
                        <a class="btn btn-primary"
                            href="{{ route('version.edit', ['hack' => $version->hack->id, 'version' => $version->id]) }}">
                            <span class="fa-solid fa-pen"></span>
                        </a>
                        <form action="{{ route('version.destroy', ['hack' => $version->hack->id, 'version' => $version->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <span class="fa-solid fa-trash"></span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
