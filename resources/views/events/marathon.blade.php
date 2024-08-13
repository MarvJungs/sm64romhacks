<x-layout>
    <div class="text-center">
        <h1 class="text-decoration-underline">{{ $event->name }}</h1>
        @if (isset($event->start_utc) && isset($event->end_utc))
            <h2 id="countdown"></h2>
        @else
            <h2>No Dates Set for the Event just yet!</h2>
        @endif
        <hr />
    </div>
    
    @if (sizeof($event->disruptions) > 0)
        @foreach ($event->disruptions as $disruption)
            @if ($disruption->active)
                <p class="alert alert-danger d-flex align-items-center" role="alert">
                    <span class="fa-solid fa-exclamation bi flex-shrink-0 me-2" role="img" aria-label="Danger:"></span>
                    <span class="m-1">{{ $disruption->created_at }}: {{ $disruption->text }}</span>
                </p>
            @endif
        @endforeach
    @endif
    
    @if ($event->description)
        @foreach (json_decode($event->description) as $item)
            {!! parseEditorText($item) !!}
        @endforeach
    @endif


    @if (isset($schedule))
        <p>The Schedule has been released! Check down the table below to make sure to not miss any runs! Be sure to head
            over to our <a href="https://www.twitch.tv/sm64romhacks" target="_blank">Event Channel</a> to catch the Action
            live!</p>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Estimate</th>
                    @foreach ($schedule['columns'] as $item)
                        <th scope="col">{{ $item }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($schedule['items'] as $item)
                    <tr>
                        <td class="scheduled_t">{{ $item['scheduled_t'] }}</td>
                        <td class="estimate_t">{{ $item['length_t'] }}</td>
                        @foreach ($item['data'] as $runInfo)
                            <td>{{ $runInfo }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <script>
        const countDownElement = document.getElementById('countdown');
        const startDate = new Date("{{ $event->start_utc }} UTC").getTime();
        const endDate = new Date("{{ $event->end_utc }} UTC").getTime();
        if (countDownElement) {
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
                    countDownElement.innerHTML = "Event starts in " + days + " days " + hours + " hours " +
                        minutes +
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
        }

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
