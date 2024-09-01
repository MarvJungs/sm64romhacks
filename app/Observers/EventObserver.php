<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventMail;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        $notifyable_users = User::where('notify', '=', 1)->get();
        foreach ($notifyable_users as $notifyable_user) {
            Mail::to($notifyable_user->email)->send(new EventMail($notifyable_user, $event));
        }

        $response = Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
            ->post(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events', [
                'entity_metadata' => [
                    'location' => 'https://www.twitch.tv/sm64romhacks'
                ],
                'name' => $event->name,
                'privacy_level' => 2,
                'scheduled_start_time' => $event->start_utc,
                'scheduled_end_time' => $event->end_utc,
                'description' => getDiscordEmbedText($event->description),
                'entity_type' => 3,
            ]);

        $event->update([
            'guild_schedule_id' => $response->json()['id'],
        ]);
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        if ($event->wasRecentlyCreated) {
            return;
        }

        $response = Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
            ->patch(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events/' . $event->guild_schedule_id, [
                'entity_metadata' => [
                    'location' => 'https://www.twitch.tv/sm64romhacks'
                ],
                'name' => $event->name,
                'privacy_level' => 2,
                'scheduled_start_time' => $event->start_utc,
                'scheduled_end_time' => $event->end_utc,
                'description' => getDiscordEmbedText($event->description),
                'entity_type' => 3,
            ]);
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        if (!is_null($event->guild_schedule_id)) {
            Http::withToken(env('DISCORD_BOT_TOKEN'), 'Bot')
                ->delete(env('DISCORD_API_URL') . 'guilds/' . env('DISCORD_GUILD_ID') . '/scheduled-events/' . $event->guild_schedule_id);
        }
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        $this->deleted($event);
    }
}
