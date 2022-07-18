<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected static function booted()
    {
        static::created(function (Media $media) {
            if ($media->model_type === Post::class) {
                Post::where('id', $media->model_id)->increment('media_count');
            }
        });
    }
}