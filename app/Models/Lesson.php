<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
    'topics_id',
    'title',
    'content',
    'video_path',
];

    protected $appends = ['video_size'];

    public function getVideoSizeAttribute()
    {
        return $this->video_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->size($this->video_path)
        : null;
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topics_id');
    }
}
