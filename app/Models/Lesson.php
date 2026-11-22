<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topics_id');
    }
}
