<?php

namespace App\Http\Controllers;

use App\Models\Romhackevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RomhackeventsController extends Controller
{
    public function index()
    {
        $events = Romhackevent::orderByDesc('start_utc')->get();
        return view('events.index', ['events' => $events]);
    }
    public function create()
    {
        return view('events.create');
    }

    public function edit(Romhackevent $event)
    {
        return view('events.edit', ['event' => $event]);
    }

    public function show(Romhackevent $event)
    {
        if ($event->external) {
            return redirect($event->external_url);
        }
        return view('events.show', ['event' => $event]);
    }

    public function store(Request $request) {
        $r = $request->validate(
            [
                'name' => 'required|min:1|max:255|string',
                'slug' => 'required|min:1|max:255|string',
                'description' => 'required|json',
                'start_utc' => 'required|date',
                'end_utc' => 'required|date',
                'external' => 'required|boolean',
                'external_url' => 'required_if_accepted:external|nullable|url'
            ]
        );
        $event = Romhackevent::create($r);
        return redirect(route('events.index'));
    }

    public function update(Request $request, Romhackevent $event) {
        $r = $request->validate(
            [
                'name' => 'required|min:1|max:255|string',
                'slug' => 'required|min:1|max:255|string',
                'description' => 'required|json',
                'start_utc' => 'required|date',
                'end_utc' => 'required|date',
                'external' => 'required|boolean',
                'external_url' => 'required_if_accepted:external|nullable|url'
            ]
        );
        $event->update($r);
        return redirect(route('events.index'));
    }

    public function destroy(Request $request, Romhackevent $event)
    {
        $event->delete();
        return view(route('events.index'));
    }
}
