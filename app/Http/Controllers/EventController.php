<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\EventType;
use App\Models\Hack;
use App\Models\LeagueCategory;
use App\Models\LeagueParticipant;
use App\Models\LeaguePointsSystem;
use App\Models\RaceParticipant;
use App\Models\RaceResult;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public string $horaro_api_endpoint = 'https://horaro.org/-/api/v1/events/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all()->sortByDesc('start_utc');
        return view('events.index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Event::class);
        $event_types = EventType::all()->pluck('type', 'id');
        return view('events.create', compact('event_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::where(['slug' => $request->slug])->get();
        if (sizeof($event) == 0) {
            $event = Event::create([
                'slug' => $request->slug,
                'name' => $request->title,
                'start_utc' => $request->start_utc != null ? $request->start_utc : null,
                'end_utc' => $request->end_utc != null ? $request->end_utc : null,
                'description' => $request->description != null ? $request->description : null,
                'event_type_id' => $request->event_type
            ]);

            if ($request->event_type == 2) {
                if (is_null($event->league)) {
                    $event->league()->create([
                        'league_points_system_id' => $request->points_system
                    ]);
                    $event->refresh();
                }

                if (!is_null($event->league->leagueCategories())) {
                    $event->league->leagueCategories()->delete();
                }

                foreach ($request->category_url as $category_url) {
                    $event->league->leagueCategories()->create([
                        'league_id' => $event->league->id,
                        'category_url' => $category_url
                    ]);
                }
            } else {
                $event->league()->delete();
            }

            return redirect(route('events.show', $event))->with('success', 'event has successfully been added');
        }
        return redirect(route('events.show', $event->first()))->with('error', 'event already exists');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        SEOMeta::setTitle($event->slug);

        OpenGraph::setTitle($event->slug);
        OpenGraph::setDescription(getOpenGraphText($event->description));
        OpenGraph::setType('Event');

        $response = Http::get($this->horaro_api_endpoint . $event->slug . '/schedules');
        if ($event->eventType->type == 'Marathon') {
            if ($response->successful()) {
                $schedules = $response->json();
                $schedule = $schedules['data'][0];
                return view('events.marathon', ['schedule' => $schedule, 'event' => $event]);
            } else {
                return view('events.marathon', ['event' => $event]);
            }
        } elseif ($event->eventType->type == 'League') {
            $leagueParticipants = LeagueParticipant::where(['league_id' => $event->league->id])->withSum('leaguePointsTable', 'points')->get();
            $leagueParticipants = $leagueParticipants->sortByDesc('league_points_table_sum_points')->values();
            $leagueCategories = $event->league->leagueCategories;
            foreach ($leagueCategories as $leagueCategory) {
                list($category_id, $subcategory_id) = explode('+', $leagueCategory->src_category_id);
                Cache::remember($leagueCategory->src_category_id, 3600, function () use ($category_id) {
                    $response = Http::get("https://www.speedrun.com/api/v1/categories/$category_id?embed=game");
                    return (object) $response->json()['data'];
                });
            }

            $leagueCategoriesTable = new Collection();


            $data = match ($event->slug) {
                'league2022' => [
                    'Star Road' => [
                        '20 Star',
                        '80 Star',
                        '130 Star',
                    ],
                    'Super Mario 74' => [
                        '10 Star',
                        '50 Star',
                        '110 Star',
                        '151 Star',
                    ],
                    'Despair Mario`s Gambit 64' => [
                        '0 Star',
                        '53 Star',
                        '120 Star',
                    ],
                    'Lug`s Delightful Dioramas' => [
                        '51 Star',
                        '74 Star',
                    ],
                    'To The Moon' => [
                        '16 Star',
                        '41 Star',
                        '85 Star'
                    ]
                ],
                'league2023' => [
                    'GS1',
                    'GS81',
                    'GS131',
                    'MNE70',
                    'MNE125',
                    'ZAR12',
                    'ZAR96',
                    'ZAR170'
                ],
                'league2024' => [
                    ['slug' => 'Eureka5', 'name' => 'Eureka 5 Star', 'cutoff' => 1380, 'barrier' => 10],
                    ['slug' => 'Eureka60', 'name' => 'Eureka 60 Star', 'cutoff' => 5400, 'barrier' => 30],
                    ['slug' => 'Eureka100', 'name' => 'Eureka 100 Star', 'cutoff' => 10800, 'barrier' => 60],
                    ['slug' => 'DL80', 'name' => 'Decades Later 80 Star', 'cutoff' => 7200, 'barrier' => 30],
                    ['slug' => 'DLABS', 'name' => 'Decades Later All Blue Stars', 'cutoff' => 7500, 'barrier' => 30],
                    ['slug' => 'DL150', 'name' => 'Decades Later 150 Star', 'cutoff' => 14400, 'barrier' => 60],
                    ['slug' => 'ZA2ANY5', 'name' => 'Ztar Attack 2 Any%', 'cutoff' => 1440, 'barrier' => 10],
                    ['slug' => 'ZA2Warpless', 'name' => 'Ztar Attack 2 Any% Warpless', 'cutoff' => 3900, 'barrier' => 20],
                    ['slug' => 'ZA290', 'name' => 'Ztar Attack 2 90 Star', 'cutoff' => 7200, 'barrier' => 30],
                ]
            };
            return view('events.league', compact('event', 'leagueParticipants', 'data'));
        } elseif ($event->eventType->type == "Race") {
            $raceParticipants = RaceParticipant::where('event_id', '=', $event->id)->get()->sortBy(function (RaceParticipant $raceParticipant, int $key) {
                $totalEstimate = $raceParticipant->sr1PB + $raceParticipant->sr2PB + $raceParticipant->sr3PB + $raceParticipant->sr4PB + $raceParticipant->sr5PB + $raceParticipant->sr6PB + $raceParticipant->sr7PB + $raceParticipant->sr8PB;
                return $totalEstimate;
            });
            $raceResults = RaceResult::where('event_id', '=', $event->id)->get()->sortBy(function (RaceResult $raceResult, int $key) {
                $totalEstimate = $raceResult->sr1PB + $raceResult->sr2PB + $raceResult->sr3PB + $raceResult->sr4PB + $raceResult->sr5PB + $raceResult->sr6PB + $raceResult->sr7PB + $raceResult->sr8PB;
                return $totalEstimate;
            });
            $registered = $raceParticipants->firstWhere('user_id', '=', Auth::user()->id) != null;
            return view('races.index', [
                'raceParticipants' => $raceParticipants,
                'raceResults' => $raceResults,
                'event' => $event,
                'registered' => $registered
            ]);
        } else {
            return view('events.special', ['event' => $event]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        Gate::authorize('update', $event);
        $event_types = EventType::all()->pluck('type', 'id');
        $points_systems = LeaguePointsSystem::all()->pluck('name', 'id');
        $hacks = Hack::all()->sortBy('name');
        return view('events.edit', compact('event', 'event_types', 'points_systems', 'hacks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update([
            'slug' => $request->slug,
            'name' => $request->name,
            'start_utc' => $request->start_utc != null ? $request->start_utc : null,
            'end_utc' => $request->end_utc != null ? $request->end_utc : null,
            'description' => $request->description != null ? $request->description : null,
            'event_type_id' => $request->event_type
        ]);

        if ($request->event_type == 2) {
            if (is_null($event->league)) {
                $event->league()->create([
                    'league_points_system_id' => $request->points_system
                ]);
                $event->refresh();
            }

            if (!is_null($event->league->leagueCategories())) {
                $event->league->leagueCategories()->delete();
            }

            foreach ($request->searchGameInput as $index => $value) {
                $event->league->leagueCategories()->create([
                    'league_id' => $event->league->id,
                    'hack_id' => Hack::where(['name' => $value])->get()->firstOrFail()->id,
                    'src_game_id' => $request->gameSelection[$index],
                    'src_category_id' => $request->categorySelection[$index],
                    'bonus_points' => $request->bonusPoints[$index],
                ]);
            }
            $event->refresh();

            $event->league->leagueParticipants()->delete();
            foreach ($request->league_display_name as $index => $value) {
                $event->league->leagueParticipants()->create([
                    'display_name' => $request->league_display_name[$index],
                    'src_name' => $request->srcName[$index]
                ]);
            }

            if ($request->points_system == 1) {
                foreach ($request->league_category_id as $index => $value) {
                    $leagueCategory = LeagueCategory::find($request->league_category_id[$index]);
                    $leagueCategory->leaguePointsPerSeconds()->create([
                        'league_category_id' => $request->league_category_id[$index],
                        'cutoff' => $request->cutoff[$index],
                        'points_per_second' => $request->pointsPerSecond[$index],
                        'tier' => $request->tier[$index]
                    ]);
                }
            }
        } else {
            $event->league()->delete();
        }
        return redirect(route('events.show', $event))->with('success', 'event has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Gate::authorize('delete', $event);

        $event->delete();
        return redirect(route('home.index'))->with('success', 'event ' . $event->name . ' has successfully been deleted');
    }
}
