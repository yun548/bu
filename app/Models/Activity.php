<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name'];

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
}