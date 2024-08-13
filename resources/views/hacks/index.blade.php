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

    function getTotalDownloads($hack)
    {
        return $hack->versions()->sum('downloadcount');
    }
@endphp

<x-layout>
    <div class="row">
        <div class="col">
            <input name="hacknameFilter" id="hacknameFilter" class="form-control" type="text"
                placeholder="Search for Hacknames...">
        </div>
        <div class="col">
            <input name="hackauthorFilter" id="hackauthorFilter" class="form-control" type="text"
                placeholder="Search for Hackauthors...">
        </div>
        <div class="col">
            <input name="releasedateFilter" id="releasedateFilter" class="form-control" type="text"
                placeholder="Search for Release Dates...">
        </div>
        <div class="col">
            <select name="tagFilter" id="tagFilter" class="form-select">
                <option value="">Select A Category</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select id="sortDropdown" class="form-select">
                <option value="">Sort By</option>
                <option value="name_asc">Hackname (ASC)</option>
                <option value="name_desc">Hackname (DESC)</option>
                <option value="releasedate_asc">Release Date (ASC)</option>
                <option value="releasedate_desc">Release Date (DESC)</option>
                <option value="starcount_desc">Starcount (ASC)</option>
                <option value="starcount_desc">Starcount (DESC)</option>
                <option value="downloads_asc">Downloads (ASC)</option>
                <option value="downloads_desc">Downloads (DESC)</option>
            </select>
        </div>
        <div class="col">
            <a class="btn btn-primary" href="/hacks/random">
                <span class="fa-solid fa-shuffle"></span>    
                Random Hack
            </a>
        </div>
        @if (Auth::check())
            <div class="col">
                <a class="btn btn-success" href="/hacks/create">
                    <span class="fa-solid fa-plus"></span>    
                    Add Hack
                </a>
            </div>
        @endif
    </div>

    <table class="table table-hover mt-3" id="hacksCollection">
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
            @foreach ($hacks as $hack)
                <tr>
                    <td><a href="/hacks/{{ $hack->id }}">{{ $hack->name }}</a></td>
                    <td>{!! getAuthorsList($hack) !!}</td>
                    <td>{{ getReleaseDate($hack) }}</td>
                    <td>{{ getStarcount($hack) }}</td>
                    <td class='text-muted'>Downloads: {{ getTotalDownloads($hack) }}</td>
                    <td hidden>{{ implode(', ', $hack->tags()->pluck('name')->toArray()) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
