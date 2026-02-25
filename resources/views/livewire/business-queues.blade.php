<div class="p-4 md:p-8">
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $business->name }}</h1>
                <p class="text-slate-400 text-sm mt-0.5">{{ $queues->count() }}
                    {{ Str::plural('queue', $queues->count()) }}</p>
            </div>
            <a href="{{ route('business.create-queue', $business->slug) }}" wire:navigate
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Queue
            </a>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div
                class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 px-4 py-3 text-emerald-400 text-sm mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Queue Cards --}}
        @if ($queues->isEmpty())
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-slate-600 mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
                <p class="text-slate-500 text-sm">No queues yet. Create your first one!</p>
            </div>
        @else
            <div class="grid gap-4">
                @foreach ($queues as $queue)
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                        wire:key="q-{{ $queue->id }}">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $queue->name }}</h3>
                            <div class="flex items-center gap-4 mt-1 text-sm text-slate-400">
                                <span>Slug: <code class="text-violet-400">/join/{{ $queue->slug }}</code></span>
                                <span>•</span>
                                <span>
                                    <span class="text-white font-medium">{{ $queue->waiting_count }}</span> waiting
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- QR Peek --}}
                            <div class="hidden md:block bg-white p-1 rounded-lg">
                                {!! QrCode::size(40)->generate(route('join.queue', $queue->slug)) !!}
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('dashboard.queue', $queue->slug) }}" wire:navigate
                                    class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-400 hover:bg-emerald-500/20 hover:text-emerald-300 transition">
                                    Dashboard
                                </a>
                                <a href="{{ url('/join/' . $queue->slug) }}" target="_blank"
                                    class="rounded-xl bg-white/5 border border-white/10 px-4 py-2 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition">
                                    Join Link ↗
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
