<div class="relative w-full min-h-screen flex flex-col items-center py-8 px-6 lg:px-12 overflow-hidden bg-slate-900">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-500/10 rounded-full blur-[100px] animate-pulse">
        </div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[100px] animate-pulse"
            style="animation-delay: 1s;"></div>
    </div>

    <header class="text-center z-10 mb-10 relative">
        <div
            class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700/50 backdrop-blur-sm mb-4">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping mr-2"></span>
            <span class="text-emerald-400 text-xs font-bold tracking-widest uppercase">Live Queue</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-black tracking-tight text-white mb-1 drop-shadow-lg">
            {{ $queue->business->name }}
        </h1>
        <p class="text-xl text-slate-400 font-medium">{{ $queue->name }}</p>
    </header>

    <main class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-12 gap-8 z-10 flex-grow">

        <!-- Now Serving (Left - Larger) -->
        <div class="lg:col-span-7 flex flex-col">
            <div
                class="glass-card relative flex-grow flex flex-col items-center justify-center p-12 text-center border-emerald-500/20 bg-gradient-to-b from-white/5 to-transparent shadow-2xl overflow-hidden group">

                <!-- Decorative ring -->
                <div class="absolute inset-0 border-2 border-emerald-500/10 rounded-[2rem] m-2 pointer-events-none">
                </div>

                @if ($nowServing)
                    <div class="relative z-10">
                        <div class="inline-block mb-6">
                            <span
                                class="px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-500 text-slate-900 shadow-[0_0_20px_rgba(16,185,129,0.4)]">
                                NOW SERVING
                            </span>
                        </div>

                        <div class="text-slate-400 font-medium text-xl uppercase tracking-widest mb-2">Ticket Number
                        </div>
                        <div
                            class="text-[10rem] lg:text-[12rem] leading-none font-black text-white drop-shadow-[0_0_60px_rgba(16,185,129,0.2)] tracking-tighter font-mono">
                            {{ $nowServing->id }}
                        </div>

                        <div class="mt-8 p-6 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-md">
                            <div class="text-sm text-slate-400 uppercase tracking-wider font-semibold mb-1">Customer
                                Name</div>
                            <div class="text-3xl md:text-4xl font-bold text-emerald-400 truncate max-w-md mx-auto">
                                {{ $nowServing->name ?? 'Guest' }}
                            </div>
                        </div>
                    </div>

                    <!-- Background Glow for Active State -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2/3 h-2/3 bg-emerald-500/5 rounded-full blur-[80px] -z-10">
                    </div>
                @else
                    <div class="text-center py-20 z-10">
                        <div
                            class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-700">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-2">Counter Closed</h3>
                        <p class="text-slate-400">Please wait for the next agent.</p>
                    </div>
                @endif
            </div>

            <!-- Stats Bar -->
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="glass-card-slim p-4 flex items-center justify-center gap-3 bg-slate-800/30">
                    <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-slate-400 uppercase font-bold">Avg Wait</div>
                        <div class="text-lg font-bold text-white">~5 mins</div>
                    </div>
                </div>
                <div class="glass-card-slim p-4 flex items-center justify-center gap-3 bg-slate-800/30">
                    <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-slate-400 uppercase font-bold">Status</div>
                        <div class="text-lg font-bold text-white">Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Up Next (Right - Sidebar style) -->
        <div class="lg:col-span-5 flex flex-col h-full">
            <div class="glass-card flex-grow p-6 border-white/5 bg-slate-900/50 flex flex-col">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/5">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="w-1 h-6 bg-blue-500 rounded-full"></span>
                        Up Next
                    </h3>
                    <span
                        class="px-2.5 py-1 bg-slate-800 text-slate-300 text-xs font-bold rounded-md border border-slate-700">
                        {{ $upcoming->count() }} Waiting
                    </span>
                </div>

                <div class="space-y-3 overflow-y-auto pr-2 custom-scrollbar flex-grow">
                    @forelse($upcoming as $index => $ticket)
                        <div
                            class="group relative p-4 rounded-xl border transition-all duration-300 
                            {{ $index === 0
                                ? 'bg-blue-600/10 border-blue-500/30 shadow-[0_0_15px_rgba(37,99,235,0.1)]'
                                : 'bg-white/5 border-white/5 hover:bg-white/10' }}">

                            @if ($index === 0)
                                <div class="absolute -left-[1px] top-4 bottom-4 w-1 bg-blue-500 rounded-r"></div>
                            @endif

                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                                        {{ $index === 0 ? 'bg-blue-500 text-white' : 'bg-slate-800 text-slate-400' }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-white font-mono tracking-tight">
                                            #{{ $ticket->id }}</div>
                                        <div class="text-sm {{ $index === 0 ? 'text-blue-200' : 'text-slate-400' }}">
                                            {{ $ticket->name ?: 'Customer' }}
                                        </div>
                                    </div>
                                </div>
                                @if ($index === 0)
                                    <span
                                        class="text-xs font-bold text-blue-400 uppercase tracking-wider animate-pulse">Next</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-500 opacity-50">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium">No one waiting</p>
                        </div>
                    @endforelse
                </div>

                <!-- QR Code Call to Action -->
                <div class="mt-6 pt-6 border-t border-white/5">
                    <div
                        class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-xl p-4 border border-white/10 flex items-center gap-4">
                        <div class="bg-white p-1.5 rounded-lg shrink-0 overflow-hidden">
                            {!! QrCode::size(80)->margin(1)->generate(route('join.queue', $queue->slug)) !!}
                        </div>
                        <div>
                            <div class="text-white font-bold text-sm">Join the Queue</div>
                            <div class="text-slate-400 text-xs">Scan to get your ticket</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer
        class="mt-8 w-full max-w-7xl flex justify-between items-center text-slate-600 text-xs font-medium tracking-widest uppercase">
        <div>{{ now()->format('l, F j, Y') }}</div>
        <div>{{ now()->format('H:i A') }}</div>
    </footer>
</div>
