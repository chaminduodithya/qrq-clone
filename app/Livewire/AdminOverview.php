<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class AdminOverview extends Component
{
    public function render()
    {
        $user = auth()->user();
        $businesses = $user->businesses()->withCount('queues')->get();

        $totalQueues = $businesses->sum('queues_count');

        $totalWaiting = Ticket::whereHas('queue.business', fn ($q) => $q->where('user_id', $user->id))
            ->where('status', 'waiting')
            ->count();

        $totalServed = Ticket::whereHas('queue.business', fn ($q) => $q->where('user_id', $user->id))
            ->where('status', 'served')
            ->count();

        return view('livewire.admin-overview', [
            'businesses' => $businesses,
            'totalQueues' => $totalQueues,
            'totalWaiting' => $totalWaiting,
            'totalServed' => $totalServed,
        ])->layout('layouts.admin', ['title' => 'Admin Overview']);
    }
}
