<?php

namespace App\Livewire;

use App\Events\QueueUpdated;
use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class QueueDashboard extends Component
{
    public Queue $queue;

    /** @var Collection<int, Ticket> */
    public Collection $tickets;

    public ?Ticket $currentServing = null;
    public string $message = '';

    public function mount(Queue $queue): void
    {
        $this->queue = $queue;
        $this->refreshTickets();
    }

    /**
     * Reload all waiting tickets from DB, ordered by position.
     */
    public function refreshTickets(): void
    {
        $this->tickets = $this->queue
            ->tickets()
            ->where('status', 'waiting')
            ->orderBy('position')
            ->get();

        // The ticket currently being served (most recent)
        $this->currentServing = $this->queue
            ->tickets()
            ->where('status', 'served')
            ->latest('updated_at')
            ->first();
    }

    /**
     * Call the next customer in line.
     */
    public function next(): void
    {
        $nextTicket = $this->queue
            ->tickets()
            ->where('status', 'waiting')
            ->orderBy('position')
            ->first();

        if (! $nextTicket) {
            $this->message = 'No customers waiting.';
            return;
        }

        // Mark as served
        $nextTicket->update(['status' => 'served']);

        // Decrement position of all remaining waiting tickets
        $this->queue->tickets()
            ->where('status', 'waiting')
            ->where('position', '>', $nextTicket->position)
            ->decrement('position');

        // Advance queue's current_position
        $this->queue->increment('current_position');
        $this->queue->refresh();

        $this->message = "Called #{$nextTicket->id}" . ($nextTicket->name ? " — {$nextTicket->name}" : '');

        // Broadcast so join pages update positions instantly
        broadcast(new QueueUpdated($this->queue));

        $this->refreshTickets();
    }

    /**
     * Cancel a specific ticket.
     */
    public function cancel(int $ticketId): void
    {
        $ticket = $this->queue->tickets()->find($ticketId);

        if (! $ticket || $ticket->status !== 'waiting') {
            $this->message = 'Ticket not found or already processed.';
            return;
        }

        $savedPosition = $ticket->position;

        $ticket->update(['status' => 'cancelled']);

        // Shift remaining waiting tickets down
        $this->queue->tickets()
            ->where('status', 'waiting')
            ->where('position', '>', $savedPosition)
            ->decrement('position');

        $this->message = "Cancelled ticket #{$ticket->id}" . ($ticket->name ? " ({$ticket->name})" : '');

        broadcast(new QueueUpdated($this->queue));

        $this->refreshTickets();
    }

    public function markServed($ticketId)
{
    $ticket = Ticket::findOrFail($ticketId);

    if ($ticket->queue_id !== $this->queue->id || $ticket->status !== 'waiting') {
        return;
    }

    $ticket->update(['status' => 'served']);

    // Only shift positions if this was NOT the first ticket
    // (if it was first, "Call Next" already handled shifting)
    if ($ticket->position > 1) {
        $this->queue->tickets()
            ->where('status', 'waiting')
            ->where('position', '>', $ticket->position)
            ->decrement('position');
    }

    broadcast(new \App\Events\QueueUpdated($this->queue))->toOthers();

    $this->refreshTickets();
}

    /**
     * Listen for real-time updates (e.g. when a customer joins from join page).
     */
    #[On('echo-private:queue.{queue.id},QueueUpdated')]
    public function onQueueUpdated(): void
    {
        $this->queue->refresh();
        $this->refreshTickets();
    }

    public function render()
    {
        return view('livewire.queue-dashboard')
            ->layout('layouts.admin', [
                'title' => 'Dashboard – ' . $this->queue->name . ' – ' . $this->queue->business->name,
            ]);
    }
}
