<?php

namespace App\Models;

use Maize\Markable\Markable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Maize\Markable\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use Markable;
    use InteractsWithMedia;
    use HasRelationships;

    protected $guarded = [];

    protected static array $marks = [
        Reaction::class,
    ];

    protected static function booted()
    {
        static::created(function (Post $post) {
            if (! is_null($post->post_id)) {
                Post::where('id', $post->post_id)->increment('shared_post_count');
            }
        });
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): hasMany
    {
        return $this->hasMany(PostComment::class);
    }

    public function sharedPost(): belongsTo
    {
        return $this->belongsTo(self::class, 'id', 'post_id')->whereNotNull('post_id');
    }

    public function popularComment(): hasOne
    {
        return $this->hasOne(PostComment::class)
            ->whereNull('parent_comment_id')
            ->with('user.media')
            ->withCount('reactions')
            ->orderByDesc('reactions_count');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('posts')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }
}