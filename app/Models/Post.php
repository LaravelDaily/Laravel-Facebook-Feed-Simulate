<?php

namespace App\Models;

use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Markable;

    protected $guarded = [];

    protected static array $marks = [
        Like::class,
        Reaction::class,
    ];
}