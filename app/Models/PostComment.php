<?php

namespace App\Models;

use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;
    use Markable;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected static array $marks = [
        Like::class,
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
}