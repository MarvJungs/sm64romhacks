@php
    function getStarcount($hack)
    {
        return $hack->versions->max('starcount');
    }

    function getAuthorsList($version)
    {
        $authors = $version->authors;
        $authorsList = '';
        foreach ($authors as $author) {
            if ($author->user) {
                $authorsList .= '<a href="' . route('users.show', $author->user) . '">' . $author->name . '</a>, ';
            } else {
                $authorsList .= $author->name . ', ';
            }
        }
        $authorsList = substr($authorsList, 0, strlen($authorsList) - 2);
        return $authorsList;
    }
@endphp

<x-layout>
    <h1>Manage Hacks</h1>
    @foreach ($hacks as $hack)
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>{{ $hack->name }} - <span class="fa-regular fa-star"></span> x {{ getStarcount($hack) }} </h2>
                <div class="d-flex gap-3">
                    <a href="{{ route('hacks.edit', $hack) }}" class="btn btn-primary">
                        <span class="fa-solid fa-pen"></span>
                        Edit Hack
                    </a>
                    <a href="{{ route('version.create', $hack) }}" class="btn btn-success">
                        <span class="fa-solid fa-plus"></span>
                        Add New Version
                    </a>
                    <a href="{{ route('hacks.show', $hack) }}" class="btn btn-info">
                        <span class="fa-solid fa-eye"></span>
                        View Hack
                    </a>
                    <form action="{{ route('hacks.destroy', $hack) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            <span class="fa-solid fa-trash"></span>
                            Delete Hack
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if ($hack->description)
                    <p>
                        @foreach (json_decode($hack->description) as $item)
                            {!! parseEditorText($item) !!}
                        @endforeach
                    </p>
                @endif

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Version</th>
                            <th>Authors</th>
                            <th>Starcount</th>
                            <th>Release Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hack->versions as $version)
                            <tr>
                                <td>{{ $version->name }}</td>
                                <td>{!! getAuthorsList($version) !!}</td>
                                <td>{{ $version->starcount }}</td>
                                <td>{{ $version->releasedate }}</td>
                                <td class="d-flex flex-row gap-2 justify-content-around">
                                    <a href="{{ route('version.edit', [$hack, $version]) }}" class="btn btn-primary">
                                        <span class="fa-solid fa-pen"></span>
                                        Edit Version
                                    </a>
                                    <form action="{{route('version.destroy', $version)}}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            <span class="fa-solid fa-trash"></span>
                                            Delete Version
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    {{ $hacks->links() }}
</x-layout>
