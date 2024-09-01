<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jakyeru\Larascord\Traits\InteractsWithDiscord;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements Sitemapable
{
    use HasFactory;
    use Notifiable;
    use InteractsWithDiscord;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'global_name',
        'discriminator',
        'email',
        'avatar',
        'verified',
        'banner',
        'banner_color',
        'accent_color',
        'locale',
        'mfa_enabled',
        'premium_type',
        'public_flags',
        'roles',
        'notify',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'global_name' => 'string',
        'discriminator' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'verified' => 'boolean',
        'banner' => 'string',
        'banner_color' => 'string',
        'accent_color' => 'string',
        'locale' => 'string',
        'mfa_enabled' => 'boolean',
        'premium_type' => 'integer',
        'public_flags' => 'integer',
        'roles' => 'json',
    ];

    public function getRouteKeyName(): string
    {
        return 'global_name';
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('users.show', $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.1);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(705528016914087976);
    }

    public function isModerator(): bool
    {
        return $this->hasRole(705528172581486704);
    }

    public function isSiteHelper(): bool
    {
        return $this->hasRole(705530192839311381);
    }

    public function isEventManager(): bool
    {
        return $this->hasRole(737674135747952660);
    }

    public function getRoles(): array|null
    {
        if (!session()->exists('guildMemberRoles')) {
            try {
                session()->put('guildMemberRoles', Auth::user()->getGuildMember(703951576162762813)->roles);
            } catch (\Throwable $th) {
                dd($th);
                session()->put('guildMemberRoles', null);
            }
        }
        $guildMemberRoles = session()->get('guildMemberRoles');
        return $guildMemberRoles;
    }

    public function hasRole($role_id): bool
    {
        $guildMemberRoles = $this->getRoles();
        return !is_null($guildMemberRoles) && in_array($role_id, $guildMemberRoles);
    }

    public function isAuthorOfHack(Hack $hack): bool
    {
        $firstVersion = $hack->versions->sortBy('releasedate')->first();
        $authors = $firstVersion->authors;
        return $authors->contains(function (Author $author) {
            return !is_null($author->user) && $author->user_id == Auth::user()->id;
        });
    }
}
