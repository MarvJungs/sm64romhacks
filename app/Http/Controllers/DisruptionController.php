<?php

namespace App\Http\Controllers;

use App\Models\Disruption;
use App\Http\Requests\StoreDisruptionRequest;
use App\Http\Requests\UpdateDisruptionRequest;
use App\Models\Event;

class DisruptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all()->sortByDesc('created_at');

        return view('disruptions.index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all()->sortByDesc('start_utc');
        return view('disruptions.create', [
            'events' => $events
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDisruptionRequest $request)
    {
        $disruption = Disruption::create([
            'event_id' => $request->event_id,
            'text' => $request->text,
        ]);

        return redirect(route('events.index'))->with('success', 'disruption has been added to the event');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisruptionRequest $request, Disruption $disruption)
    {
        if (filter_var($disruption->active, FILTER_VALIDATE_BOOLEAN)) {
            $disruption->update([
                'active' => false
            ]);
            $disruption->save();
            return redirect(route('disruptions.index'))->with('success', 'disruption was set to inactive');
        } elseif (!filter_var($disruption->active, FILTER_VALIDATE_BOOLEAN)) {
            $disruption->update([
                'active' => true
            ]);
            $disruption->save();
            return redirect(route('disruptions.index'))->with('success', 'disruption was set to active');
        }
    }
}
