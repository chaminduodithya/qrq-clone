<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Queue;
use Livewire\Attributes\On;

class PublicDisplay extends Component
{
    public Queue $queue;

    public $nowServing = null;          // Last served or current
    public $upcoming = [];              // Next 3–5 waiting
    public $message = 'Please wait...'; // Custom welcome or paused msg

    public function mount(Queue $queue)
    {
        $this->queue = $queue;
        $this->refreshDisplay();
    }

    public function refreshDisplay()
    {
        // Current serving: last served ticket (or first waiting if none served yet)
        $this->nowServing = $this->queue->tickets()
            ->where('status', 'served')
            ->latest('updated_at')
            ->first();

        // Upcoming: next 5 waiting
        $this->upcoming = $this->queue->tickets()
            ->where('status', 'waiting')
            ->orderBy('position')
            ->take(5)
            ->get();

        // Optional: if queue paused or empty
        if ($this->upcoming->isEmpty()) {
            $this->message = 'No customers waiting – Queue is open!';
        }
    }

    #[On('echo-private:queue.{queue.id},QueueUpdated')]
    public function handleQueueUpdate()
    {
        $this->refreshDisplay();
    }

    public function render()
    {
        return view('livewire.public-display', [
            'queue' => $this->queue
        ])->layout('layouts.display', [
            'queue' => $this->queue
        ]);
    }
}