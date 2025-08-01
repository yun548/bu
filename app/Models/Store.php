<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'siret',
        'customs_code',
        'document_path',
    ];
    
    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }
}