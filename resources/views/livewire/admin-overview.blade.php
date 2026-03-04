<div class="p-4 md:p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <h1 class="text-2xl font-bold text-white">Welcome back, {{ auth()->user()->name }}</h1>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Institutes</p>
                <p class="text-3xl font-bold text-white">{{ $businesses->count() }}</p>
            </div>
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Queues</p>
                <p class="text-3xl font-bold text-violet-400">{{ $totalQueues }}</p>
            </div>
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Waiting Now</p>
                <p class="text-3xl font-bold text-amber-400">{{ $totalWaiting }}</p>
            </div>
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Total Served</p>
                <p class="text-3xl font-bold text-emerald-400">{{ $totalServed }}</p>
            </div>
        </div>

        {{-- Business List --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Your Institutes</h2>
                <a href="{{ route('businesses.create') }}" wire:navigate
                    class="text-sm text-violet-400 hover:text-violet-300 transition">+ New</a>
            </div>

            @if ($businesses->isEmpty())
                <div class="px-5 py-12 text-center">
                    <p class="text-slate-500 text-sm">No institutes yet.</p>
                    <a href="{{ route('businesses.create') }}" wire:navigate
                        class="inline-block mt-3 text-sm text-violet-400 hover:text-violet-300 underline underline-offset-4 transition">
                        Create your first institute
                    </a>
                </div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach ($businesses as $business)
                        <a href="{{ route('business.queues', $business->slug) }}" wire:navigate
                            class="flex items-center justify-between px-5 py-4 hover:bg-white/[0.02] transition">
                            <div>
                                <p class="text-white font-medium">{{ $business->name }}</p>
                                <p class="text-slate-500 text-xs mt-0.5">{{ $business->queues_count }}
                                    {{ Str::plural('queue', $business->queues_count) }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
