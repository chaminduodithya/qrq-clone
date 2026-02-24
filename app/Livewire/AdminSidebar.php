<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminSidebar extends Component
{
    public function render()
    {
        $businesses = Auth::user()->businesses()->with('queues')->get();

        return view('livewire.admin-sidebar', [
            'businesses' => $businesses,
        ]);
    }
}
