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
                            {{-- <div class="hidden md:block bg-white p-1 rounded-lg">
                                {!! QrCode::size(40)->generate(route('join.queue', $queue->slug)) !!}
                            </div> --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('dashboard.queue', $queue->slug) }}" wire:navigate
                                    class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-400 hover:bg-emerald-500/20 hover:text-emerald-300 transition">
                                    Dashboard
                                </a>
                                <a href="{{ route('queue.qr', $queue->slug) }}" wire:navigate
                                    title="View & Print QR Code"
                                    class="rounded-xl bg-violet-500/10 border border-violet-500/20 px-4 py-2 text-sm font-medium text-violet-400 hover:bg-violet-500/20 hover:text-violet-300 transition inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 18.75h.75v.75h-.75v-.75zM18.75 13.5h.75v.75h-.75v-.75zM18.75 18.75h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                    </svg>
                                    QR Code
                                </a>
                                <a href="{{ route('display.queue', $queue->slug) }}" target="_blank"
                                    title="Open Public Display Screen"
                                    class="rounded-xl bg-sky-500/10 border border-sky-500/20 px-4 py-2 text-sm font-medium text-sky-400 hover:bg-sky-500/20 hover:text-sky-300 transition inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                                    </svg>
                                    Public Display ↗
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
