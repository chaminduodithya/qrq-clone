<?php

namespace App\Livewire;

use App\Models\Queue;
use Livewire\Component;

class QueueQr extends Component
{
    public Queue $queue;

    public function mount(Queue $queue): void
    {
        $this->queue = $queue;
    }

    public function render()
    {
        return view('livewire.queue-qr')
            ->layout('layouts.admin', ['title' => $this->queue->name . ' – QR Code']);
    }
}
