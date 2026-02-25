<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['queue_id', 'position', 'name', 'phone', 'joined_at', 'status', 'push_subscription'];

    protected $casts = [
        'push_subscription' => 'array',
        'joined_at' => 'datetime',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
