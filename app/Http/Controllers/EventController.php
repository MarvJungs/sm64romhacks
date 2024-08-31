<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Mail\EventMail;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
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
        $notifyable_users = User::where('notify', '=', true)->get();
        if (sizeof($event) == 0) {
            $response = Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
            ->post(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events', [
                'entity_metadata' => [
                    'location' => 'https://www.twitch.tv/sm64romhacks'
                ],
                'name' => $request->title,
                'privacy_level' => 2,
                'scheduled_start_time' => $request->start_utc,
                'scheduled_end_time' => $request->end_utc,
                'description' => getDiscordEmbedText($request->description),
                'entity_type' => 3,
            ]);
            $event = Event::create([
                'slug' => $request->slug,
                'name' => $request->title,
                'guild_schedule_id' => $response->json()['id'],
                'start_utc' => $request->start_utc != null ? $request->start_utc : null,
                'end_utc' => $request->end_utc != null ? $request->end_utc : null,
                'description' => $request->description != null ? $request->description : null,
                'marathon' => isset($request->marathon)
            ]);
            foreach ($notifyable_users as $notifyable_user) {
                Mail::to($notifyable_user->email)->send(new EventMail($notifyable_user, $event));
            }
            return redirect(route('events.show', $event))->with('success', 'event has successfully been added');
        }
        return redirect(route('events.show', $event))->with('error', 'event already exists');
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
        $response = Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
            ->patch(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events/' . $event->guild_schedule_id, [
                'entity_metadata' => [
                    'location' => 'https://www.twitch.tv/sm64romhacks'
                ],
                'name' => $request->name,
                'privacy_level' => 2,
                'scheduled_start_time' => $request->start_utc,
                'scheduled_end_time' => $request->end_utc,
                'description' => getDiscordEmbedText($request->description),
                'entity_type' => 3,
            ]);
        $event->update([
            'slug' => $request->slug,
            'name' => $request->name,
            'guild_schedule_id' => $response->notFound() ? null : $response->json()['id'],
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
        if (!is_null($event->guild_schedule_id)) {
            $response = Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
                ->delete(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events/' . $event->guild_schedule_id);
        }
        $event->delete();
        return redirect(route('home.index'))->with('success', 'event ' . $event->name . ' has successfully been deleted');
    }
}
