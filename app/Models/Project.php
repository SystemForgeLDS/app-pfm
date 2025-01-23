<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";

    public function client() 
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
