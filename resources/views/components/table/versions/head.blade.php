<thead>
    <tr>
        <th scope="col">Hack Name</th>
        <th scope="col">Hack Version</th>
        <th scope="col">Download Link</th>
        <th scope="col">Creator</th>
        <th scope="col">Starcount</th>
        <th scope="col">Release Date</th>
        @if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isSiteHelper()))
            <th scope="col">
                Actions
            </th>
        @endif
    </tr>
</thead>
