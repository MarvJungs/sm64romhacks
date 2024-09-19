    <h1>League 2023 Points Calculator</h1>
    <table class="table table-bordered table-hover" id="pointsTable">
        <thead>
            <tr>
                <th>
                    <select class="form-select" name="runners" id="runners">
                        <option id="none" @selected(true)>Please Select A Runner</option>
                    </select>
                </th>
                <th>Your Rank</th>
                <th>Your Time</th>
                <th>Your Points</th>
                <th>Rank To Beat</th>
                <th>Time To Beat</th>
                <th>Points To Gain</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $category)
                <tr>
                    <td>{{ $category }}</td>
                    <td id="{{ strtolower($category) }}_rank1"></td>
                    <td id="{{ strtolower($category) }}_time1"></td>
                    <td id="{{ strtolower($category) }}_points1"></td>
                    <td> <select class="form-select" id="{{ strtolower($category) }}_rank0"></select></td>
                    <td id="{{ strtolower($category) }}_time0"></td>
                    <td id="{{ strtolower($category) }}_points0"></td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td colspan="2"></td>
                <td id="total"></td>
                <td colspan="2"></td>
                <td id="total_gain"></td>
            </tr>
        </tbody>
    </table>
