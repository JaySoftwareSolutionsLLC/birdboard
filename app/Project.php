<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    // Function to create path of project (show) on the fly. This allows one spot to change if endpoint changes rather than multiple spots in multiple files
    public function path() {
        return "/projects/{$this->id}";
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }
}
