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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    // T&V LU&R pg 51
    /*
    public function getRouteKeyName()
    {
        return 'slug';
    }
    */
}
