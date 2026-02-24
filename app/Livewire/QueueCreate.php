<?php

namespace App\Livewire;

use App\Models\Business;
use Illuminate\Support\Str;
use Livewire\Component;

class QueueCreate extends Component
{
    public Business $business;

    public string $name = '';
    public string $slug = '';
    public bool $slugManuallyEdited = false;

    public function mount(Business $business): void
    {
        $this->business = $business;
    }

    public function updatedName($value): void
    {
        if (! $this->slugManuallyEdited) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedSlug($value): void
    {
        $this->slugManuallyEdited = ! empty($value);
    }

    public function create(): void
    {
        $this->slug = Str::slug($this->slug);

        $this->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|alpha_dash|unique:queues,slug',
        ]);

        $this->business->queues()->create([
            'name'             => $this->name,
            'slug'             => $this->slug,
            'current_position' => 0,
        ]);

        session()->flash('success', "Queue \"{$this->name}\" created!");

        $this->redirect(route('business.queues', $this->business->slug), navigate: true);
    }

    public function render()
    {
        return view('livewire.queue-create')
            ->layout('layouts.admin', ['title' => 'New Queue – ' . $this->business->name]);
    }
}
