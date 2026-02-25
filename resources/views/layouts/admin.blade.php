<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Queue Admin' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-950 text-white" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        {{-- ── Sidebar ── --}}
        @livewire('admin-sidebar')

        {{-- ── Mobile Overlay ── --}}
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        {{-- ── Main Content ── --}}
        <main class="flex-1 lg:ml-64 min-h-screen">
            {{-- Mobile top bar --}}
            <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-slate-900 border-b border-white/10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="text-sm font-semibold text-white">Queue Admin</span>
                <div class="w-6"></div>
            </div>

            {{ $slot }}
        </main>
    </div>


</body>

</html>
