    <h1>League 2024 Points Calculator</h1>
    <h2>How it works:</h2>
    <p>Your points are being determined by two factors:</p>
    <ul>
        <li>Rankpoints (based off Leaderboard position)</li>
        <li>Timepoints (based off your time you got)</li>
    </ul>
    <h3>Rankpoints:</h3>
    <p>Rankpoints are determined by your Leaderboard position. Points are being calculated as the following:</p>
    <ul>
        <li>The last place will receive 1 point.</li>
        <li>For each better placement, you will receive an additional point.</li>
        <li>If you are between place 6 and 10, you will receive 2 points for each better placement, starting from rank
            10.</li>
        <li>If you are between place 1 and 5, you will receive 3 points for each better placement, starting from rank 5
        </li>
    </ul>
    <p>There will be a bonus points attached to your rankpoints, those are determined by the nature length of a
        category. You get these once for a category if you finished a run</p>
    <h3>Timepoints</h3>
    <p>Timepoints are determined by your Time you got. Points are calculated the following way:</p>
    <ul>
        <li>Each category holds a cutoff. You start to receive points once you broke the cutoff.</li>
        <li>Each category holds a threshold (in seconds) to break, starting from the cutoff. For every time you break
            this threshold, you receive 1 point.</li>
        <li>There are no bonus time points to be gotten</li>
    </ul>
    <table class="table table-bordered table-hover" id="pointsTable2024">
        <thead>
            <tr>
                <th>
                    <select class="form-select" name="runners" id="runners">
                        <option value="none" @selected(true)>Select A Runner</option>
                    </select>
                </th>
                <th hidden>Cutoff</th>
                <th hidden>Threshold</th>
                <th>Your Rank</th>
                <th>Your Time</th>
                <th hidden>Your Leaderboard Points</th>
                <th hidden>Your Time Points</th>
                <th>Total Points</th>
                <th>Rank To Beat</th>
                <th>Desired Endtime</th>
                <th hidden>Possible Leaderboard Points</th>
                <th hidden>Possible Time Points</th>
                <th>Total Points To Gain</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $category)
                <tr name="{{ strtolower($category['slug']) }}">
                    <td>{{ $category['name'] }}</td>
                    <td id="{{ strtolower($category['slug']) }}_cutoff" hidden>{{ $category['cutoff'] }}</td>
                    <td id="{{ strtolower($category['slug']) }}_barrier" hidden>{{ $category['barrier'] }}</td>
                    <td id="{{ strtolower($category['slug']) }}_rank1"></td>
                    <td id="{{ strtolower($category['slug']) }}_time1"></td>
                    <td class="rankPoints" id="{{ strtolower($category['slug']) }}_points1" hidden></td>
                    <td class="timePoints" id="{{ strtolower($category['slug']) }}_timePoints" hidden>0</td>
                    <td class="totalPoints" id="{{ strtolower($category['slug']) }}__totalPoints">0</td>
                    <td> <select class="form-select" id="{{ strtolower($category['slug']) }}_rank0"></select></td>
                    <td>
                        <input id="{{ strtolower($category['slug']) }}_desiredTime" class="form-control" type="text"
                            value="9:59:59">
                    </td>
                    <td class="possibleRankPoints" id="{{ strtolower($category['slug']) }}_possibleRankPoints" hidden>0</td>
                    <td class="possibleTimePoints" id="{{ strtolower($category['slug']) }}_possibleTimePoints" hidden>0</td>
                    <td class="possibleTotalPoints" id="{{ strtolower($category['slug']) }}_possibleTotalPoints">0</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-bg-info text-dark">Total</td>
                <td colspan="2" class="text-bg-info text-dark" hidden></td>
                <td colspan="2" class="text-bg-info text-dark"></td>
                <td id="total_rankPoints" class="text-bg-info text-dark" hidden>0</td>
                <td id="total_timePoints" class="text-bg-info text-dark" hidden>0</td>
                <td id="total_points" class="text-bg-info text-dark">0</td>
                <td colspan="2" class="text-bg-info text-dark"></td>
                <td id="total_gain" class="text-bg-info text-dark" hidden></td>
                <td id="total_possibleTimePoints" class="text-bg-info text-dark" hidden>0</td>
                <td id="total_possiblePoints" class="text-bg-info text-dark">0</td>
            </tr>
        </tbody>
    </table>
