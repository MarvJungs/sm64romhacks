<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">
                Place
            </th>
            <th scope="col">
                Runner
            </th>
            <th scope="col">
                Time
            </th>
            <th scope="col">
                Points
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pointsLeaderboard as $rank => $run)
            <tr>
                <td>
                    {{ $rank + 1 }}
                </td>
                <td>
                    <a href="{{ $run->leagueParticipant->src_name }}">
                        {{ $run->leagueParticipant->display_name }}
                    </a>
                </td>
                <td>
                    {{ $run->personal_best }}
                </td>
                <td>
                    {{ $run->points }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
