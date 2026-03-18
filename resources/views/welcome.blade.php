<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Queue Admin') }} - Smart Queue Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f111a;
            color: #f8fafc;
            overflow-x: hidden;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient {
            background: linear-gradient(135deg, #a78bfa 0%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .shape-blob {
            position: absolute;
            filter: blur(90px);
            z-index: -1;
            opacity: 0.5;
            animation: float 10s infinite ease-in-out;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Background Blobs -->
    <div class="shape-blob bg-indigo-600/30 w-[500px] h-[500px] rounded-full top-[-100px] left-[-100px]"></div>
    <div class="shape-blob bg-violet-600/30 w-[400px] h-[400px] rounded-full bottom-[10%] right-[-50px]" style="animation-delay: 2s;"></div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-panel border-b-0 border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">{{ config('app.name', 'Queue Admin') }}</span>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition group relative">
                            Dashboard
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-500 transition-all group-hover:w-full"></span>
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-white/10 border border-white/10 rounded-lg hover:bg-white/20 transition backdrop-blur-md">
                                Register Setup
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                
                <!-- Text Content -->
                <div class="lg:col-span-5 text-center lg:text-left mb-16 lg:mb-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold uppercase tracking-wide mb-6">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Smart Queue Generation V1.0
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                        Eradicate Lines.<br>
                        <span class="text-gradient">Elevate Flow.</span>
                    </h1>
                    
                    <p class="text-lg text-slate-400 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        The ultimate intelligent queue management platform. Instant QR onboarding, real-time ticket tracking, and powerful business insights all in one sleek dashboard.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold text-center hover:from-violet-500 hover:to-indigo-500 transition shadow-[0_0_40px_rgba(99,102,241,0.4)] hover:shadow-[0_0_60px_rgba(99,102,241,0.6)]">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('admin.login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold text-center hover:from-violet-500 hover:to-indigo-500 transition shadow-[0_0_40px_rgba(99,102,241,0.4)] hover:shadow-[0_0_60px_rgba(99,102,241,0.6)]">
                                Login to Start Your Queue
                            </a>
                            <a href="#features" class="w-full sm:w-auto px-8 py-4 rounded-xl glass-panel text-white font-semibold text-center hover:bg-white/10 transition">
                                Explore Features
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Mockup Image -->
                <div class="lg:col-span-7 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 rounded-[2.5rem] blur-3xl transform rotate-3"></div>
                    <div class="glass-panel p-2 rounded-[2rem] shadow-2xl relative transform -rotate-2 hover:rotate-0 transition duration-700 hover:scale-[1.02]">
                        <img src="{{ asset('images/hero-mockup.png') }}" alt="QRQ System Dashboard Mockup" class="w-full h-auto rounded-[1.5rem] border border-white/5 object-cover" loading="lazy">
                        
                        <!-- Floating Badges -->
                        <div class="absolute -top-6 -right-6 glass-panel px-6 py-4 rounded-2xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium uppercase">Wait Time</p>
                                <p class="text-lg font-bold text-white">-45%</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 relative border-t border-white/5 bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Built for scale. Designed for humans.</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Everything you need to run efficient queues without forcing your customers to download another app.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-panel p-8 rounded-2xl hover:-translate-y-2 transition duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-indigo-500/10 flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 transition">
                        <svg class="w-7 h-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Instant QR Access</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Customers simply scan a QR code at your location to join the queue. No app downloads or tedious registrations required.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-panel p-8 rounded-2xl hover:-translate-y-2 transition duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-violet-500/10 flex items-center justify-center mb-6 group-hover:bg-violet-500/20 transition">
                        <svg class="w-7 h-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.38-.443 1.96-1.115 2.506-1.13 2.518a.5.5 0 00.569.755c1.1-.55 2.148-1.222 2.94-1.6A8.954 8.954 0 0012 20.25z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h.01M12 12h.01M15 12h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Live Push Notifications</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Through Laravel Reverb WebSockets, users get instant live updates on their queue position right in their mobile browser.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-panel p-8 rounded-2xl hover:-translate-y-2 transition duration-300 group">
                    <div class="w-14 h-14 rounded-xl bg-fuchsia-500/10 flex items-center justify-center mb-6 group-hover:bg-fuchsia-500/20 transition">
                        <svg class="w-7 h-7 text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Advanced Analytics</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Monitor service times, peak hours, and staff efficiency via our intuitive, data-packed admin dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-12 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="w-6 h-6 rounded-md bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5" />
                    </svg>
                </div>
                <span class="font-bold tracking-tight">{{ config('app.name', 'Queue Admin') }}</span>
            </div>
            <p class="text-slate-500 text-sm">
                Built with Laravel, Livewire, and TailwindCSS. &copy; {{ date('Y') }}. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
