<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    protected $fillable = ['title', 'course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
