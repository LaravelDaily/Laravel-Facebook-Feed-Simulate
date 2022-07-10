<?php

namespace App\Models;

use Maize\Markable\Markable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;
    use Markable;

    protected static array $marks = [
        Reaction::class,
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): hasMany
    {
        return $this->hasMany(self::class, 'parent_comment_id', 'id');
    }

    public function popularReply()
    {
        return $this->hasOne(self::class, 'parent_comment_id', 'id')
            ->with('user.media')
            ->withCount('reactions')
            ->orderByDesc('reactions_count');
    }
}