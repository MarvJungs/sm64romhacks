<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackeventRequest;
use App\Http\Requests\UpdateRomhackeventRequest;
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

    public function store(StoreRomhackeventRequest $request) {
        $r = $request->validated();
        $event = Romhackevent::create($r);
        return redirect(route('events.index'));
    }

    public function update(UpdateRomhackeventRequest $request, Romhackevent $event) {
        $r = $request->validated();
        $event->update($r);
        return redirect(route('events.index'));
    }

    public function destroy(Request $request, Romhackevent $event)
    {
        $event->delete();
        return view(route('events.index'));
    }
}
