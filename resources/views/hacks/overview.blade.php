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
                } else {
                    $authorsList .= $author->name . ', ';
                }
            }
            $authorsList = substr($authorsList, 0, strlen($authorsList) - 2);
        } else {
            $authorsList = 'unknown';
        }
        return $authorsList;
    }
@endphp

<section id="hacksCollection">
    <table class="table table-hover mt-3" id="hacksTable">
        <thead>
            <tr>
                <th scope="col">Hackname</th>
                <th scope="col">Creator</th>
                <th scope="col">Initial Release Date</th>
                <th scope="col">Starcount</th>
                <th scope="col">Downloads</th>
                <th scope="col" hidden>Tags</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($hacks as $hack)
                <tr>
                    <td><a href="/hacks/{{ $hack->id }}">{{ $hack->name }}</a></td>
                    <td>{!! getAuthorsList($hack) !!}</td>
                    <td>{{ $hack->release_date }}</td>
                    <td>{{ $hack->starcount }}</td>
                    <td class='text-muted'>Downloads: {{ $hack->total_downloads }}</td>
                    <td hidden>{{ implode(', ', $hack->tags()->pluck('name')->toArray()) }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</section>
