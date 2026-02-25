<?php

namespace App\Livewire;

use App\Models\Queue;
use App\Models\Ticket;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;  // ← add this (Livewire 3+)

class JoinQueue extends Component
{
    public Queue $queue;

    public $pushSubscription = null;

    #[Url(as: 'ticket')] // ← this makes ?ticket=... reactive in URL
    public $ticketId = null;

    public $name = '';

    public $phone = '';

    public $ticket = null;

    public $position = null;

    public $estimatedWait = null; // optional

    public function mount(Queue $queue)
    {
        $this->queue = $queue;

        // If ticket ID in URL (?ticket=...), check if it belongs to this session
        if ($this->ticketId) {
            $sessionKey = "queue_{$this->queue->id}_ticket";
            $ownedTicketId = session($sessionKey);

            if ($this->ticketId == $ownedTicketId) {
                $this->ticket = Ticket::find($this->ticketId);

                if ($this->ticket && $this->ticket->queue_id === $this->queue->id && $this->ticket->status === 'waiting') {
                    $this->position = $this->ticket->position;
                    $this->estimatedWait = $this->calculateETA();
                } else {
                    $this->ticketId = null;
                    $this->ticket = null;
                }
            } else {
                // Not authorized to view this ticket
                $this->ticketId = null;
                $this->ticket = null;
            }
        }
    }

    public function join()
    {
        $this->validate([
            'name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
        ]);

        if ($this->name && $this->phone) {
            $existing = Ticket::where('queue_id', $this->queue->id)
                ->where('status', 'waiting')
                ->where('name', $this->name)
                ->where('phone', $this->phone)
                ->first();

            if ($existing) {
                $this->ticket = $existing;
                $this->ticketId = $existing->id;
                $this->position = $existing->position;
                $this->estimatedWait = $this->calculateETA();

                // Restore ownership in session
                session(["queue_{$this->queue->id}_ticket" => $existing->id]);

                $this->addError('phone', 'Welcome back! You already have an active ticket.');

                return;
            }
        }

        $newPosition = $this->queue->nextPosition(); // your helper

        $this->ticket = Ticket::create([
            'queue_id' => $this->queue->id,
            'position' => $newPosition,
            'name' => $this->name,
            'phone' => $this->phone,
            'joined_at' => now(),
        ]);

        $this->ticketId = $this->ticket->id;
        $this->position = $newPosition;
        $this->estimatedWait = $this->calculateETA();

        // Store ownership in session
        session(["queue_{$this->queue->id}_ticket" => $this->ticket->id]);

        broadcast(new \App\Events\QueueUpdated($this->queue))->toOthers();
    }

    public function savePushSubscription($subscription)
    {
        if ($this->ticket) {
            $this->ticket->update([
                'push_subscription' => $subscription,
            ]);
        }
    }

    // Optional: simple ETA (e.g. 5 min per person ahead)
    private function calculateETA()
    {
        if (! $this->position) {
            return 'Calculating...';
        }

        $peopleAhead = $this->position - 1;
        $avgMinutes = 10; // ← your suggested value

        $minutes = $peopleAhead * $avgMinutes;

        if ($minutes === 0) {
            return 'You are next – very soon!';
        }

        if ($minutes <= 15) {
            return "About $minutes minutes";
        }

        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        if ($hours > 0) {
            return "About $hours hour".($hours > 1 ? 's' : '').($minutes ? " $minutes min" : '');
        }

        return "About $minutes minutes";
    }

    #[On('echo-private:queue.{queue.id},QueueUpdated')]
    public function refreshPosition()
    {
        if ($this->ticket) {
            $this->ticket->refresh();
            $this->position = $this->ticket->position;
            $this->estimatedWait = $this->calculateETA();

            if ($this->ticket->status !== 'waiting') {
                // handle served/cancelled if needed
            }
        }
    }

    public function render()
    {
        return view('livewire.join-queue')->layout('layouts.public');
    }
}
