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
                    $authorsList .= '<a href="' . route('users.show', $author->user) . '">' . $author->name . '</a>, ';
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
    <table class="table table-hover" id="hacksTable">
        <thead>
            <tr>
                <th id="hack" class="clickable text-primary" scope="col">Hackname</th>
                <th id="creator" class="clickable text-primary" scope="col">Creator</th>
                <th id="releasedate" class="clickable text-primary" scope="col">Release Date</th>
                <th id="starcount" class="clickable text-primary" scope="col">Starcount</th>
                <th id="downloads" class="clickable text-primary" scope="col">Downloads</th>
                <th scope="col" hidden>Tags</th>
            </tr>
        </thead>
        <tbody id="hacksTableBody">         
        </tbody>
    </table>
</section>
