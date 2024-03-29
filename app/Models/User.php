<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Overtrue\LaravelFollow\Traits\Follower;
use Spatie\MediaLibrary\InteractsWithMedia;
use Overtrue\LaravelFollow\Traits\Followable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Overtrue\LaravelFollow\Followable as FollowableModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use Follower, Followable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at'       => 'datetime',
    ];

    public function followersPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, FollowableModel::class, 'user_id', 'followable_id', 'id', 'user_id');
    }

    public function posts(): hasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): hasMany
    {
        return $this->hasMany(PostComment::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->fit(Manipulations::FIT_CROP, 32, 32)
            ->nonQueued();
    }
}
