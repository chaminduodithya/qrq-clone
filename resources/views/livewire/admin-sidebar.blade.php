<aside x-data :class="$store?.sidebarOpen ?? sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-white/10 transform lg:translate-x-0 transition-transform duration-300 flex flex-col">
    {{-- ── Brand ── --}}
    <div class="p-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-white">Queue Admin</h1>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- ── Navigation ── --}}
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">
        {{-- Overview --}}
        <a href="{{ route('admin.dashboard') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                  {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            Overview
        </a>

        {{-- Create Business --}}
        <a href="{{ route('businesses.create') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                  {{ request()->routeIs('businesses.create') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            New Business
        </a>

        {{-- ── Business Sections ── --}}
        @foreach ($businesses as $business)
            <div class="pt-4">
                <p class="px-3 mb-2 text-[10px] uppercase tracking-widest text-slate-500 font-semibold">
                    {{ $business->name }}</p>

                {{-- Queues list --}}
                <a href="{{ route('business.queues', $business->slug) }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition
                          {{ request()->routeIs('business.queues') && request()->route('business')?->id === $business->id ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                    Queues
                </a>

                {{-- Individual queue shortcuts --}}
                @foreach ($business->queues as $queue)
                    <a href="{{ route('dashboard.queue', $queue->slug) }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-1.5 pl-10 rounded-xl text-xs transition
                              {{ request()->routeIs('dashboard.queue') && request()->route('queue')?->id === $queue->id ? 'bg-violet-500/10 text-violet-400 font-medium' : 'text-slate-500 hover:bg-white/5 hover:text-slate-300' }}">
                        {{ $queue->name }}
                    </a>
                @endforeach

                {{-- New Queue --}}
                <a href="{{ route('business.create-queue', $business->slug) }}" wire:navigate
                    class="flex items-center gap-3 px-3 py-2 pl-10 rounded-xl text-xs transition text-slate-500 hover:bg-white/5 hover:text-slate-300">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Queue
                </a>
            </div>
        @endforeach
    </nav>

    {{-- ── Footer ── --}}
    <div class="p-3 border-t border-white/10">
        <a href="{{ route('profile.edit') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-400 hover:bg-white/5 hover:text-white transition">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Log Out
            </button>
        </form>
    </div>
</aside>
