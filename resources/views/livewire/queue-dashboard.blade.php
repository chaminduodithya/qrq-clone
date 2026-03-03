<div class="p-6 lg:p-10 bg-slate-950 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">{{ $queue->name }}</h1>
                @if ($queue->business)
                    <p class="text-slate-400 text-sm mt-0.5">{{ $queue->business->name }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="relative flex h-2.5 w-2.5">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-slate-300">Live Dashboard</span>
            </div>
        </div>

        {{-- ── Flash Message ── --}}
        @if ($message)
            <div
                class="rounded-xl bg-violet-500/10 border border-violet-500/20 px-4 py-3 text-violet-300 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @endif

        {{-- ── Stats Cards ── --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            {{-- Waiting --}}
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Waiting</p>
                <p class="text-3xl font-bold text-white">{{ $tickets->count() }}</p>
            </div>
            {{-- Current Position --}}
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Served So Far</p>
                <p class="text-3xl font-bold text-violet-400">{{ $queue->current_position }}</p>
            </div>
            {{-- Now Serving --}}
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5 col-span-2">
                <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Now Serving</p>
                @if ($currentServing)
                    <p class="text-3xl font-bold text-emerald-400">
                        #{{ $currentServing->id }}
                        @if ($currentServing->name)
                            <span class="text-lg font-medium text-slate-300">— {{ $currentServing->name }}</span>
                        @endif
                    </p>
                @else
                    <p class="text-xl font-medium text-slate-500">No one yet</p>
                @endif
            </div>
        </div>

        {{-- Message Display --}}
        @if ($message)
            <div
                class="bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-4 text-center text-sm font-medium text-indigo-400">
                {{ $message }}
            </div>
        @endif

        {{-- ── Call Next Button ── --}}
        <button wire:click="next"
            class="w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4 text-base font-bold text-white shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:scale-[1.005] active:scale-[0.995] transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:shadow-emerald-500/20 disabled:hover:scale-100"
            wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="next" class="flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                Call Next Customer
            </span>
            <span wire:loading wire:target="next" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Processing…
            </span>
        </button>

        {{-- ── Waiting Tickets Table ── --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h2 class="text-lg font-semibold text-white">Waiting Queue</h2>
            </div>

            @if ($tickets->isEmpty())
                <div class="px-5 py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-600 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-slate-500 text-sm">No customers waiting right now.</p>
                </div>
            @else
                {{-- Desktop table --}}
                <div class="hidden md:block">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-slate-400 text-xs uppercase tracking-wider border-b border-white/5">
                                <th class="px-5 py-3">Pos</th>
                                <th class="px-5 py-3">Ticket #</th>
                                <th class="px-5 py-3">Name</th>
                                <th class="px-5 py-3">Phone</th>
                                <th class="px-5 py-3">Joined</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($tickets as $ticket)
                                <tr class="hover:bg-white/[0.02] transition" wire:key="ticket-{{ $ticket->id }}">
                                    <td class="px-5 py-3">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-violet-500/10 text-violet-400 font-bold text-sm">
                                            {{ $ticket->position }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-white font-medium">#{{ $ticket->id }}</td>
                                    <td class="px-5 py-3 text-slate-300">{{ $ticket->name ?: '—' }}</td>
                                    <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $ticket->phone ?: '—' }}
                                    </td>
                                    <td class="px-5 py-3 text-slate-400">
                                        {{ \Carbon\Carbon::parse($ticket->joined_at)->diffForHumans() }}</td>
                                    <td class="px-5 py-3 text-right space-x-2">
                                        <button wire:click="markServed({{ $ticket->id }})"
                                            wire:confirm="Mark {{ $ticket->name ?? 'this customer' }} as served?"
                                            wire:loading.attr="disabled"
                                            class="rounded-lg bg-green-500/10 border border-green-500/20 px-3 py-1.5 text-xs font-medium text-green-400 hover:bg-green-500/20 hover:text-green-300 transition">
                                            Mark as Served
                                        </button>
                                        <button wire:click="cancel({{ $ticket->id }})"
                                            wire:confirm="Cancel ticket #{{ $ticket->id }}?"
                                            wire:loading.attr="disabled"
                                            class="rounded-lg bg-red-500/10 border border-red-500/20 px-3 py-1.5 text-xs font-medium text-red-400 hover:bg-red-500/20 hover:text-red-300 transition">
                                            Cancel Queue Number
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="md:hidden divide-y divide-white/5">
                    @foreach ($tickets as $ticket)
                        <div class="px-5 py-4 flex items-center justify-between gap-4"
                            wire:key="m-ticket-{{ $ticket->id }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-violet-500/10 text-violet-400 font-bold text-base shrink-0">
                                    {{ $ticket->position }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-white font-medium text-sm truncate">
                                        #{{ $ticket->id }} {{ $ticket->name ? '— ' . $ticket->name : '' }}
                                    </p>
                                    <p class="text-slate-500 text-xs">
                                        {{ \Carbon\Carbon::parse($ticket->joined_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button wire:click="markServed({{ $ticket->id }})"
                                    wire:confirm="Mark {{ $ticket->name ?? 'this customer' }} as served?"
                                    wire:loading.attr="disabled"
                                    class="rounded-lg bg-green-500/10 border border-green-500/20 px-3 py-1.5 text-xs font-medium text-green-400 hover:bg-green-500/20 transition shrink-0">
                                    Served
                                </button>
                                <button wire:click="cancel({{ $ticket->id }})"
                                    wire:confirm="Cancel ticket #{{ $ticket->id }}?" wire:loading.attr="disabled"
                                    class="rounded-lg bg-red-500/10 border border-red-500/20 px-3 py-1.5 text-xs font-medium text-red-400 hover:bg-red-500/20 transition shrink-0">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Footer ── --}}
        <p class="text-center text-xs text-slate-600 pb-4">Powered by QRQ</p>
    </div>
</div>
