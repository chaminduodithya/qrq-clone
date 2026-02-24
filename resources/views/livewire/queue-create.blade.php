<div class="p-4 md:p-8">
    <div class="max-w-lg mx-auto">

        <div class="mb-6">
            <a href="{{ route('business.queues', $business->slug) }}" wire:navigate
                class="text-sm text-violet-400 hover:text-violet-300 transition">← Back to {{ $business->name }}</a>
            <h1 class="text-2xl font-bold text-white mt-2">New Queue</h1>
            <p class="text-slate-400 text-sm mt-0.5">for {{ $business->name }}</p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <form wire:submit="create" class="space-y-5">

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Queue Name</label>
                    <input wire:model.live.debounce.300ms="name" type="text" id="name"
                        placeholder="e.g. Haircut"
                        class="w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition">
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-300 mb-1.5">Slug</label>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-sm">/join/</span>
                        <input wire:model="slug" type="text" id="slug" placeholder="haircut"
                            class="flex-1 rounded-xl bg-white/5 border border-white/10 px-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition font-mono">
                    </div>
                    @error('slug')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="create">Create Queue</span>
                    <span wire:loading wire:target="create">Creating…</span>
                </button>

            </form>
        </div>
    </div>
</div>
