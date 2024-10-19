<x-layout>
    <div class="text-center">
        <h1 class="text-decoration-underline">{{ $event->name }}</h1>
        <h2 id="countdown"></h2>
        <hr />
    </div>

    @if (sizeof($event->disruptions) > 0)
        @foreach ($event->disruptions as $disruption)
            @if ($disruption->active)
                <p class="alert alert-danger d-flex align-items-center" role="alert">
                    <span class="fa-solid fa-exclamation bi flex-shrink-0 me-2" role="img" aria-label="Danger:"></span>
                    <span class="m-1">
                        <span class="time">
                            {{ $disruption->created_at }}:
                        </span>
                        {{ $disruption->text }}</span>
                </p>
            @endif
        @endforeach
    @endif


    @if ($event->description)
        @foreach (json_decode($event->description) as $item)
            {!! parseEditorText($item) !!}
        @endforeach
    @endif

    <h2>Categories</h2>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">Game</th>
                <th scope="col">Category</th>
                <th scope="col">Leaderboard</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($event->league->leagueCategories as $leagueCategory)
                <tr>
                    <td>
                        <a href="{{ route('hacks.show', $leagueCategory->hack) }}">
                            {{ $leagueCategory->hack->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ cache($leagueCategory->src_category_id)->weblink }}">
                            {{ cache($leagueCategory->src_category_id)->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('leagueCategory.show', [$event, $leagueCategory]) }}">
                            Leaderboard
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="calculator">
        @include('apps.' . $event->slug)
    </div>

    {{-- <h2>User Leaderboard</h2>
    <p>Note: May not be 100% accurate as people tend to delete their runs or change their speedrun.com names in which case their runs will not be found</p>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">Rank</th>
                <th scope="col">Username</th>
                <th scope="col">Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leagueParticipants as $index => $leagueParticipant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $leagueParticipant->display_name }}</td>
                    <td>{{ $leagueParticipant->league_points_table_sum_points ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}

    <script>
        const countDownElement = document.getElementById('countdown');
        const startDate = new Date("{{ $event->start_utc }} UTC").getTime();
        const endDate = new Date("{{ $event->end_utc }} UTC").getTime();

        const x = setInterval(() => {
            const now = new Date().getTime();
            const startDistance = startDate - now;
            const endDistance = endDate - now;
            const days = Math.floor(endDistance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((endDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((endDistance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((endDistance % (1000 * 60)) / 1000);

            if (startDistance > 0) {
                const days = Math.floor(startDistance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((startDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((startDistance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((startDistance % (1000 * 60)) / 1000);
                countDownElement.innerHTML = "Event starts in " + days + " days " + hours + " hours " + minutes +
                    " minutes " + seconds + " seconds";
            } else if (startDistance < 0 && endDistance > 0) {
                const days = Math.floor(endDistance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((endDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((endDistance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((endDistance % (1000 * 60)) / 1000);
                countDownElement.innerHTML = "Event ends in " + days + " days " + hours + " hours " + minutes +
                    " minutes " + seconds + " seconds";
            } else {
                clearInterval(x);
                countDownElement.innerHTML = "Event Ended!";
            }
        }, 1000);

        Array.from(document.getElementsByClassName('scheduled_t')).forEach((element) => {
            const utcDate = new Date(Number(element.innerHTML) * 1000);
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false,
            };
            element.innerHTML = utcDate.toLocaleDateString('en-US', {
                weekday: 'long'
            }) + ', ' + utcDate.toLocaleString('sv', options);
        });

        Array.from(document.getElementsByClassName('estimate_t')).forEach((element) => {
            const duration = new Date(Number(element.innerHTML) * 1000).toISOString().slice(11, 19);
            element.innerHTML = duration;
        });
    </script>
</x-layout>
