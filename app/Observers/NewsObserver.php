<?php

namespace App\Observers;

use App\Mail\NewsMail;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     */
    public function created(News $news): void
    {
        Http::post(env('DISCORD_WEBHOOK_URI'), [
            'content' => $news->important ? '@everyone' : null,
            'username' => 'sm64romhacks News',
            'avatar_url' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/f6dd682a-ce61-40d1-ab3a-54dc6c174092-profile_image-70x70.png',
            'embeds' => [
                [
                    'title' => mb_strlen($news->title) > 256 ? mb_substr($news->title, 0, 256 - 3) . '...' : $news->title,
                    'type' => 'rich',
                    'description' => mb_strlen(getDiscordEmbedText($news->text)) > 4096 ? mb_substr(getDiscordEmbedText($news->text), 0, 4096 - 3) . '...' : getDiscordEmbedText($news->text),
                    'url' => 'https://www.sm64romhacks.com/news/' . $news->id,
                    'timestamp' => Carbon::now(),
                    'color' => rand(0x000000, 0xFFFFFF),
                    'footer' => [
                        'text' => 'This is an official sm64romhacks message. These messages will never be sent out by a different service other than sm64romhacks.com. Be careful where the links leads to.',
                        'icon_url' => 'https://www.sm64romhacks.com/_assets/_img/icon.ico'
                    ],
                    'author' => [
                        'name' => 'sm64romhacks',
                        'url' => 'https://www.sm64romhacks.com',
                        'icon_url' => 'https://www.sm64romhacks.com/_assets/_img/logo.png'
                    ],
                    "fields" => [
                        [
                            "name" => "Category",
                            "value" => "[News](https://www.sm64romhacks.com/news)",
                            "inline" => true
                        ],
                        [
                            "name" => "Author",
                            "value" => Auth::user()->global_name,
                            "inline" => true
                        ]
                    ],
                ]
            ],
            'allowed_mentions' => [
                'parse' => [
                    'everyone'
                ]
            ],
        ]);

        // $notifyable_users = User::where(['notify' => 1])->get();

        // foreach ($notifyable_users as $notifyable_user) {
        //     Mail::to($notifyable_user->email)->send(new NewsMail($notifyable_user, $news));
        // }
    }

    /**
     * Handle the News "updated" event.
     */
    public function updated(News $news): void
    {
        //
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        //
    }

    /**
     * Handle the News "restored" event.
     */
    public function restored(News $news): void
    {
        //
    }

    /**
     * Handle the News "force deleted" event.
     */
    public function forceDeleted(News $news): void
    {
        //
    }
}
