<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel Login — {{ config('app.name', 'QueueApp') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-950 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600/20 border border-indigo-500/30 mb-4">
                <svg class="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Queue Admin Access</h1>
            <p class="text-slate-400 text-sm mt-1">Sign in to manage your queues and businesses</p>
        </div>

        {{-- Card --}}
        <div class="bg-slate-900 border border-white/10 rounded-2xl shadow-2xl p-8">

            {{-- Access-denied flash error (from middleware) --}}
            @if (session('error'))
                <div class="mb-5 flex items-start gap-3 rounded-lg bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-400">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Session status (e.g. password reset link sent) --}}
            @if (session('status'))
                <div class="mb-5 rounded-lg bg-emerald-500/10 border border-emerald-500/30 px-4 py-3 text-sm text-emerald-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">
                        Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@example.com"
                        class="w-full rounded-lg bg-slate-800 border border-white/10 text-white placeholder-slate-500
                               px-4 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                               transition
                               @error('email') border-red-500/60 @enderror"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg bg-slate-800 border border-white/10 text-white placeholder-slate-500
                               px-4 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                               transition
                               @error('password') border-red-500/60 @enderror"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center gap-2 cursor-pointer">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-600 bg-slate-800 text-indigo-500 focus:ring-indigo-500"
                        >
                        <span class="text-sm text-slate-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-indigo-400 hover:text-indigo-300 transition"
                        >
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-lg bg-indigo-600 hover:bg-indigo-500
                           text-white font-semibold text-sm py-2.5 px-4
                           transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                           focus:ring-offset-slate-900"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Log in as Admin
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-slate-600 mt-6">
            This portal is restricted to authorised administrators only.
        </p>
    </div>

</body>
</html>
