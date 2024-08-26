<?php

namespace App\Observers;

use App\Mail\RegisteredMail;
use App\Models\User;
use App\Models\Author;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Mail;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $connections = $user->getConnections();
        if ($connections->isNotEmpty()) {
            $twitch_connection = $connections->filter(function ($value, $key) {
                return $value->type == 'twitch';
            })->first();
            if ($twitch_connection->verified) {
                $twitch_name = $twitch_connection->name;
                $author = Author::where(['name' => $twitch_name])->get()->first();
                $user->update([
                    'author_id' => $author->id
                ]);
            }
        }

        Mail::to($user)->send(new RegisteredMail($user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
