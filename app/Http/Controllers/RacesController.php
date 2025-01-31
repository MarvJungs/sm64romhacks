<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RaceParticipant;
use App\Models\RaceResult;
use Illuminate\Http\RedirectResponse;

class RacesController extends Controller
{
    public function register(Request $request, Event $event): View|RedirectResponse
    {
        if ($request->has('_token')) {
            if ($request->has('checkReadRules')) {
                RaceParticipant::create([
                    'user_id' => $request->user()->id,
                    'event_id' => $event->id,
                    'sr1PB' => convertDurationToSeconds($request->sr1Time),
                    'sr2PB' => convertDurationToSeconds($request->sr2Time),
                    'sr3PB' => convertDurationToSeconds($request->sr3Time),
                    'sr4PB' => convertDurationToSeconds($request->sr4Time),
                    'sr5PB' => convertDurationToSeconds($request->sr5Time),
                    'sr6PB' => convertDurationToSeconds($request->sr6Time),
                    'sr7PB' => convertDurationToSeconds($request->sr7Time),
                    'sr8PB' => convertDurationToSeconds($request->sr8Time),
                    'accept_rules' => $request->has('checkReadRules')
                ]);
                return redirect(route('events.show', ['event' => $event]))->with('success', 'Successfully signed up');
            } else {
                return back()->with('error', 'You must agree to the Rules');
            }
        }
        if (Auth::user()) {
            return view('races.register', ['event' => $event]);
        }
        abort(403);
    }

    public function unregister(Request $request, Event $event): RedirectResponse
    {
        if ($request->has('_token')) {
            $raceParticipants = RaceParticipant::where('event_id', '=', $event->id)->get();
            $raceParticipant = $raceParticipants->firstWhere('user_id', '=', Auth::user()->id);
            if ($raceParticipant != null) {
                $raceParticipant->delete();
                return redirect(route('events.show', ['event' => $event]))->with('success', 'You have successfully unregistered from the race. You may always re-register, if you desire to do so');
            }
        }
        abort(404);
    }

    public function results(Event $event, Request $request): View|RedirectResponse
    {
        if ($request->has('_token')) {
            RaceResult::where('event_id', '=', $event->id)->delete();
            foreach ($request->runner as $index => $value) {
                RaceResult::create([
                    'user_id' => $request->runner[$index],
                    'event_id' => $event->id,
                    'sr1Time' => convertDurationToSeconds($request->sr1Time[$index]),
                    'sr2Time' => convertDurationToSeconds($request->sr2Time[$index]),
                    'sr3Time' => convertDurationToSeconds($request->sr3Time[$index]),
                    'sr4Time' => convertDurationToSeconds($request->sr4Time[$index]),
                    'sr5Time' => convertDurationToSeconds($request->sr5Time[$index]),
                    'sr6Time' => convertDurationToSeconds($request->sr6Time[$index]),
                    'sr7Time' => convertDurationToSeconds($request->sr7Time[$index]),
                    'sr8Time' => convertDurationToSeconds($request->sr8Time[$index]),
                    'totalStars' => $request->totalStars[$index]
                ]);
            }
            return back()->with('success', 'The Results have successfully been entered!');
        }
        $raceParticipants = RaceParticipant::where('event_id', '=', $event->id)->get()->sortBy(function (RaceParticipant $raceParticipant, int $key) {
            $totalEstimate = $raceParticipant->sr1PB + $raceParticipant->sr2PB + $raceParticipant->sr3PB + $raceParticipant->sr4PB + $raceParticipant->sr5PB + $raceParticipant->sr6PB + $raceParticipant->sr7PB + $raceParticipant->sr8PB;
            return $totalEstimate;
        });
        return view('races.results-form', ['raceParticipants' => $raceParticipants, 'event' => $event]);
    }
}
