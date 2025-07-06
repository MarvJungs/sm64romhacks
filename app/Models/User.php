<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    /**
     *  @use HasFactory<\Database\Factories\UserFactory>
    **/
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'twitch_id',
        'discord_id',
        'country_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the country that belongs to the User.
     * 
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The roles that belong to the user.
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Gets newsposts from user
     * 
     * @return HasMany<Newspost, User>
     */
    public function newsposts(): HasMany
    {
        return $this->hasMany(Newspost::class);
    }

    /**
     * Summary of comments
     * 
     * @return HasMany<Comment, User>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Checks if user has specified role
     * 
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        $roles = $this->roles;
        $wantedRole = Role::where('name', $role)->get()->first();
        return $roles->contains($wantedRole);
    }

    /**
     * Summary of hasRatedComment
     * 
     * @param \App\Models\Comment $comment Comment
     * 
     * @return void
     */
    public function hasLikedComment(Comment $comment): bool
    {
        return $comment->ratings->where('rating', 1)->pluck('user_id')->contains($this->id);
    }

    /**
     * Summary of hasRatedComment
     * 
     * @param \App\Models\Comment $comment Comment
     * 
     * @return void
     */
    public function hasDislikedComment(Comment $comment): bool
    {
        return $comment->ratings->where('rating', -1)->pluck('user_id')->contains($this->id);
    }

    /**
     * Summary of isAuthorOf
     * 
     * @param \App\Models\Comment|\App\Models\Newspost $post
     * 
     * @return bool
     */
    public function isAuthorOf(Comment|Newspost $post): bool
    {
        return $post->user->id === $this->id;
    }
}
