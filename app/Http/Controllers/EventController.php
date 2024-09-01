<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Gate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

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
        return view('events.create');
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
                'marathon' => isset($request->marathon)
            ]);
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
        if ($event->marathon) {
            if ($response->successful()) {
                $schedules = $response->json();
                $schedule = $schedules['data'][0];
                return view('events.marathon', ['schedule' => $schedule, 'event' => $event]);
            } else {
                return view('events.marathon', ['event' => $event]);
            }
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
        return view('events.edit', ['event' => $event]);
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
            'marathon' => isset($request->marathon)
        ]);

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
