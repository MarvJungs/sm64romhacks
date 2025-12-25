<div>
    @if ($error)
        <h2 class="text-decoration-underline">Schedule</h2>
        <p>No Schedule could be found :(</p>
    @else
        @foreach ($schedules['data'] as $schedule)
            <h2 class="text-decoration-underline">{{ $schedule['name'] }}</h2>
            <table class="table table-border table-hover">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Estimate</th>
                        @foreach ($schedule['columns'] as $columns)
                            <th>{{ $columns }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedule['items'] as $item)
                        <tr>
                            <td>{{ $item['scheduled_t'] }}</td>
                            <td>{{ $item['length_t'] }}</td>
                            @foreach ($item['data'] as $data)
                                <td>{{ $data }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</div>
