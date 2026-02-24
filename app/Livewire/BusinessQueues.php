<?php

namespace App\Livewire;

use App\Models\Business;
use Livewire\Component;

class BusinessQueues extends Component
{
    public Business $business;

    public function mount(Business $business): void
    {
        $this->business = $business;
    }

    public function render()
    {
        $queues = $this->business->queues()
            ->withCount(['tickets as waiting_count' => fn ($q) => $q->where('status', 'waiting')])
            ->get();

        return view('livewire.business-queues', [
            'queues' => $queues,
        ])->layout('layouts.admin', ['title' => $this->business->name . ' – Queues']);
    }
}
