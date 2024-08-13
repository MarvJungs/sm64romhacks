@php
    function getAuthorsList($hack)
    {
        $versions = $hack->versions()->orderBy('releasedate', 'asc')->get();
        $firstVersion = $versions->first();
        if ($firstVersion) {
            $authors = $firstVersion->authors;
            $authorsList = '';
            foreach ($authors as $author) {
                if ($author->user) {
                    $authorsList .= '<a href="/users/' . $author->user->id . '">' . $author->name . '</a>, ';
                }
                else {
                    $authorsList .= $author->name . ', ';
                }
            }
            $authorsList = substr($authorsList, 0, strlen($authorsList) - 2);
        } else {
            $authorsList = 'unknown';
        }
        return $authorsList;
    }

    function getReleaseDate($hack)
    {
        return $hack->versions()->orderBy('releasedate', 'asc')->pluck('releasedate')->first();
    }

    function getStarcount($hack)
    {
        return $hack->versions()->max('starcount');
    }
@endphp

<x-layout>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Hackname</th>
            <th>Creators</th>
            <th>Initial Release Date</th>
            <th>Starcount</th>
            <th>Submitted At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach ($hacks as $hack)
                <tr>
                    <td><a href="/hacks/{{ $hack->id }}">{{ $hack->name }}</a></td>
                    <td>{!! getAuthorList($hack) !!}</td>
                    <td>{{ getReleaseDate($hack) }}</td>
                    <td>{{ getStarcount($hack) }}</td>
                    <td>{{ $hack->created_at }}</td>
                    <td class="d-flex">

                        <form action="/hacks" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <button class="btn btn-success m-2" type="submit">
                                <span class="fa-regular fa-circle-check"></span>
                            </button>
                        </form>

                        <form action="/hacks" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="hack_id" value="{{ $hack->id }}">
                            <button class="btn btn-danger m-2" type="submit">
                                <span class="fa-regular fa-xmark"></span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
