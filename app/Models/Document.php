<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
            'due_at' => 'datetime',
            'emitted_at' => 'datetime',
        ];
    }
}
