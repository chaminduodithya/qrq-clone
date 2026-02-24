<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class BusinessCreate extends Component
{
    public string $name = '';
    public string $slug = '';
    public bool $slugManuallyEdited = false;

    /**
     * Auto-generate slug from name unless the user has manually edited it.
     */
    public function updatedName($value): void
    {
        if (! $this->slugManuallyEdited) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Mark slug as manually edited once the user types in it.
     */
    public function updatedSlug($value): void
    {
        $this->slugManuallyEdited = ! empty($value);
    }

    public function create(): void
    {
        $this->slug = Str::slug($this->slug);

        $this->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:businesses,slug|alpha_dash',
        ]);

        $business = auth()->user()->businesses()->create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        session()->flash('success', "Business \"{$business->name}\" created!");

        $this->redirect(route('business.queues', $business->slug), navigate: true);
    }

    public function render()
    {
        return view('livewire.business-create')
            ->layout('layouts.admin', ['title' => 'Create Business']);
    }
}
