<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['business_id', 'name', 'slug', 'current_position'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Helper: get next waiting position
    public function nextPosition()
    {
        return $this->tickets()->where('status', 'waiting')->max('position') + 1 ?? 1;
    }
}
