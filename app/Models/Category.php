<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];

    use HasFactory;

    public function expenses() 
    {
        return $this->hasMany('App\Models\Expense');
    }
}
