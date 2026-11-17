<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['project_id', 'body'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
