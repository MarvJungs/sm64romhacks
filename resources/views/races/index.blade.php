@inject('role', \App\Models\Role::class)

<x-layout>
    <style>
        .raceCategories {
            padding-left: 1rem;
        }

        .raceCategories li::marker {
            content: ">";
            font-weight: 800;
        }

        .blindEstimatesList {
            list-style: none;
        }

        td.runnerHeader {
            background-color: #8e7cc3;
            color: black;
        }

        td.sr1Header,
        .sr1Header {
            background-color: #37e0f8;
            color: black;
        }

        td.sr2Header,
        .sr2Header {
            background-color: #0099f8;
            color: black;
        }

        td.sr3Header,
        .sr3Header {
            background-color: #fcdc00;
            color: black;
        }

        td.sr4Header,
        .sr4Header {
            background-color: #e1aa00;
            color: black;
        }

        td.sr5Header,
        .sr5Header {
            background-color: #a0d8f8;
            color: black;
        }

        td.sr6Header,
        .sr6Header {
            background-color: #93c47d;
            color: black;
        }

        td.sr7Header,
        .sr7Header {
            background-color: #00a8f8;
            color: black;
        }

        td.placementHeader {
            background-color: #e69138;
            color: black;
        }

        td.sr8Header,
        .sr8Header {
            background-color: #f00b05;
            color: black;
        }

        td.totalHeader {
            background-color: #c27ba0;
            color: black;
        }

        td.runnerItem {
            background-color: #d9d2e9;
            color: black;
        }

        td.placementItem {
            background-color: #f9cb9c;
            color: black;
        }

        td.sr1Item {
            background-color: #99e3f3;
            color: black;
        }

        td.sr2Item {
            background-color: #cfe2f3;
            color: black;
        }

        td.sr3Item {
            background-color: #fff2cc;
            color: black;
        }

        td.sr4Item {
            background-color: #ffd966;
            color: black;
        }

        td.sr5Item {
            background-color: #c9daf8;
            color: black;
        }

        td.sr6Item {
            background-color: #b6d7a8;
            color: black;
        }

        td.sr7Item {
            background-color: #a4c2f4;
            color: black;
        }

        td.sr8Item {
            background-color: #f4cccc;
            color: black;
        }

        td.totalItem {
            background-color: #ead1dc;
            color: black;
        }

        .postLink {
            background-color: transparent;
            border: none;
            color: #00bc8c;
            text-decoration: none;
        }

        .postLink:hover {
            text-decoration: underline;
            color: #007053;
        }
    </style>
    <ul class="nav nav-tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="signups-tab" data-bs-toggle="tab" data-bs-target="#signups-tab-pane"
                type="button" role="tab" aria-controls="signups-tab-pane" aria-selected="true">
                Race Signups
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="results-tab" data-bs-toggle="tab" data-bs-target="#results-tab-pane"
                type="button" role="tab" aria-controls="results-tab-pane" aria-selected="false">
                Results
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <h1>THE SCRUBS CHALLENGE RACE!!! @<span class="time">{{ $event->start_utc }}</span></h1>
        <div class="tab-pane fade show active" id="signups-tab-pane" role="tabpanel" aria-labelledby="signups-tab"
            tabindex="0">
            <table class="table table-borderless table-sm">
                <thead>
                    <tr class="table-info">
                        <td colspan="3">
                            &nbsp;
                        </td>
                        <td colspan="3">
                            @if (!$registered)
                                <a href="{{ route('races.register', ['event' => $event]) }}">Registration Form</a>
                            @else
                                <form action="{{ route('races.unregister', ['event' => $event]) }}" method="post">
                                    @csrf
                                    <input class="postLink" type="submit" value="Unregister"></input>
                                </form>
                            @endif
                        </td>
                        <td colspan="3">
                            <a href="https://discord.gg/BYrpMBG">Discord Server</a>
                        </td>
                        <td colspan="2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Rules
                            </a>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="runnerHeader">Runner</td>
                        <td class="sr1Header">SR1.5 66</td>
                        <td class="sr2Header">SR2 TTM 41</td>
                        <td class="sr3Header">SR3 36</td>
                        <td class="sr4Header">SR4.5 50</td>
                        <td class="sr5Header">SR5 31</td>
                        <td class="sr6Header">SR6 50</td>
                        <td class="sr7Header">SR7 61</td>
                        <td class="sr8Header">SR8 80</td>
                        <td class="totalHeader">Total</td>
                    </tr>
                    @foreach ($raceParticipants as $raceParticipant)
                        <tr>
                            <td class="runnerItem">{{ $raceParticipant->user->global_name }}</td>
                            <td class="sr1Item">{{ convertSecondsToDuration($raceParticipant->sr1PB) }}</td>
                            <td class="sr2Item">{{ convertSecondsToDuration($raceParticipant->sr2PB) }}</td>
                            <td class="sr3Item">{{ convertSecondsToDuration($raceParticipant->sr3PB) }}</td>
                            <td class="sr4Item">{{ convertSecondsToDuration($raceParticipant->sr4PB) }}</td>
                            <td class="sr5Item">{{ convertSecondsToDuration($raceParticipant->sr5PB) }}</td>
                            <td class="sr6Item">{{ convertSecondsToDuration($raceParticipant->sr6PB) }}</td>
                            <td class="sr7Item">{{ convertSecondsToDuration($raceParticipant->sr7PB) }}</td>
                            <td class="sr8Item">{{ convertSecondsToDuration($raceParticipant->sr8PB) }}</td>
                            <td class="totalItem">{{ convertSecondsToDuration($raceParticipant->totalPB) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="runnerItem">Theoretical WR</td>
                        <td class="sr1Item">00:51:45</td>
                        <td class="sr2Item">00:32:38</td>
                        <td class="sr3Item">00:24:51</td>
                        <td class="sr4Item">00:39:57</td>
                        <td class="sr5Item">00:23:27</td>
                        <td class="sr6Item">00:39:41</td>
                        <td class="sr7Item">00:40:54</td>
                        <td class="sr8Item">01:15:11</td>
                        <td class="totalItem">05:28:24</td>
                    </tr>
                    <tr>
                        <td class="runnerItem">Blind Estimates</td>
                        <td class="sr1Item">02:30:00</td>
                        <td class="sr2Item">02:00:00</td>
                        <td class="sr3Item">01:00:00</td>
                        <td class="sr4Item">02:00:00</td>
                        <td class="sr5Item">01:00:00</td>
                        <td class="sr6Item">02:00:00</td>
                        <td class="sr7Item">02:30:00</td>
                        <td class="sr8Item">03:00:00</td>
                        <td class="totalItem">16:00:00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane fade" id="results-tab-pane" role="tabpanel" aria-labelledby="results-tab" tabindex="0">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <td class="placementHeader">#</td>
                        <td class="runnerHeader">Runner</td>
                        <td class="sr1Header">SR1.5 66</td>
                        <td class="sr2Header">SR2 TTM 41</td>
                        <td class="sr3Header">SR3 36</td>
                        <td class="sr4Header">SR4.5 50</td>
                        <td class="sr5Header">SR5 31</td>
                        <td class="sr6Header">SR6 50</td>
                        <td class="sr7Header">SR7 61</td>
                        <td class="sr8Header">SR8 80</td>
                        <td class="totalHeader" colspan="2">Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raceResults as $index => $raceResult)
                        <tr>
                            <td class="placementItem">{{$index + 1}}</td>
                            <td class="runnerItem">{{$raceResult->user->global_name}}</td>
                            <td class="sr1Item">{{$raceResult->sr1Time <= 600 ? "$raceResult->sr1Time Stars" : convertSecondstoDuration($raceResult->sr1Time)}}</td>
                            <td class="sr2Item">{{$raceResult->sr2Time <= 600 ? "$raceResult->sr2Time Stars" : convertSecondstoDuration($raceResult->sr2Time)}}</td>
                            <td class="sr3Item">{{$raceResult->sr3Time <= 600 ? "$raceResult->sr3Time Stars" : convertSecondstoDuration($raceResult->sr3Time)}}</td>
                            <td class="sr4Item">{{$raceResult->sr4Time <= 600 ? "$raceResult->sr4Time Stars" : convertSecondstoDuration($raceResult->sr4Time)}}</td>
                            <td class="sr5Item">{{$raceResult->sr5Time <= 600 ? "$raceResult->sr5Time Stars" : convertSecondstoDuration($raceResult->sr5Time)}}</td>
                            <td class="sr6Item">{{$raceResult->sr6Time <= 600 ? "$raceResult->sr6Time Stars" : convertSecondstoDuration($raceResult->sr6Time)}}</td>
                            <td class="sr7Item">{{$raceResult->sr7Time <= 600 ? "$raceResult->sr7Time Stars" : convertSecondstoDuration($raceResult->sr7Time)}}</td>
                            <td class="sr8Item">{{$raceResult->sr8Time <= 600 ? "$raceResult->sr8Time Stars" : convertSecondstoDuration($raceResult->sr8Time)}}</td>
                            <td class="totalItem">{{$raceResult->totalTime <= 8 * 600 ? "DNF" : convertSecondstoDuration($raceResult->totalTime)}}</td>
                            <td class="totalItem">{{$raceResult->totalStars}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (Auth::user()->hasRole($role::ADMIN))
                <div class="row">
                    <a href="{{ route('races.results', ['event' => $event]) }}" class="btn btn-primary"><span
                            class="fa fa-pen"></span> Edit Results</a>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Rules</h1>
                </div>
                <div class="modal-body">
                    <p>
                        This is an RTA Race of 8 SM64 ROM Hacks part of the "Star Revenge" Series, done in their Any%
                        ISC (Intended Star Count) Categories, for a total of 415 Stars combined. The 8 runs in order
                        are:
                    </p>
                    <ol class="raceCategories">
                        <li>Star Revenge 1.5: Star Takeover Redone - 66 Star</li>
                        <li>Star Revenge 2 Act I: To the Moon - 41 Star</li>
                        <li>Star Revenge 3: Mario On An Saoire 64 - 36 Star</li>
                        <li>Star Revenge 4.5: The Kedama Takeover Rewritten - 50 Star</li>
                        <li>Star Revenge 5: Neo Blue Realm - 31 Star</li>
                        <li>Star Revenge 6: Luigi's Adventure - 50 Star</li>
                        <li>Star Revenge 7: Park Of Time - 61 Star</li>
                        <li>Star Revenge 8: Scepter Of Hope - 80 Star</li>
                    </ol>
                    <hr />
                    <p>
                        <strong>
                            Feel free to compete, but remember that this will be raced on <a
                                href="https://therun.gg">therun.gg</a>.
                    </p>
                    <p>Breaks can be as long as you keep the timer running.</p>
                    <p> You do not have to stream if you are taking an extended break to sleep but please leave the
                        timer ON so your time is accurate at the end. Streaming is REQUIRED.</p>
                    </strong>
                    <hr />
                    <p>
                        Blind Run Estimates: (If you haven't completed a run of these categories, they should be the
                        default when you open the sign up form):
                    </p>
                    <ul class="blindEstimatesList">
                        <li class="sr1Header"> SR1.5 +2.5 hours</li>
                        <li class="sr2Header">SR2 TTM +2 hours</li>
                        <li class="sr3Header">SR3 +1 hours</li>
                        <li class="sr4Header">SR4.5 +2 hours</li>
                        <li class="sr5Header">SR5 +1 hour</li>
                        <li class="sr6Header">SR6 +2 hours</li>
                        <li class="sr7Header">SR7 +2.5 hours</li>
                        <li class="sr8Header">SR8 +3 hours</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
