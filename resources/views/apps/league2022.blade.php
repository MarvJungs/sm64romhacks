<x-layout>
    <h1>League 2022 Points Calculator</h1>
    <p>
        This is the official League 2022 Points calculator. This should help you to determine which time you need to
        reach a certain amount of points. To get started just enter your beginning PB for the corresponding category and
        what time you wish to archive and it will tell you the amount of points you gain from it!
    </p>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="calc">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($games as $game => $categories)
                        <th colspan="{{ sizeof($categories) }}">{{ $game }}</th>
                    @endforeach
                    <th>Totals</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>{{ $category }}</td>
                        @endforeach
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td>Starting PB</td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>
                                <input class="form-control w-auto" type="text" size="7" maxlength="7" value="9:59:59">
                            </td>
                        @endforeach
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td>Ending PB</td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>
                                <input class="form-control w-auto" type="text" size="7" max="7" value="9:59:59">
                            </td>
                        @endforeach
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td>Points</td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>
                                0
                            </td>
                        @endforeach
                    @endforeach
                    <td>0</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>
                                0
                            </td>
                        @endforeach
                    @endforeach
                    <td>0</td>
                </tr>
                <tr>
                    <td>Total</td>
                    @foreach ($games as $categories)
                        @foreach ($categories as $category)
                            <td>
                                0
                            </td>
                        @endforeach
                    @endforeach
                    <td>0</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout>
