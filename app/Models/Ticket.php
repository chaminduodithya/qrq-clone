<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['queue_id', 'position', 'name', 'phone', 'joined_at', 'status'];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
