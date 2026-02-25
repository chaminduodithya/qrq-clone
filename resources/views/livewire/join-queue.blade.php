<div
    class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        {{-- ── Header ── --}}
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 mb-4 shadow-lg shadow-violet-500/25">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">{{ $queue->business?->name ?? 'Unknown Business' }}</h1>
            <p class="text-slate-400 mt-1 text-sm">{{ $queue->name }} Queue</p>
        </div>

        {{-- ── CARD ── --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl overflow-hidden">

            @if ($ticket && $position)
                {{-- ══════════ TICKET CONFIRMATION ══════════ --}}
                <div class="p-6 text-center space-y-6">

                    {{-- Success badge --}}
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 px-4 py-1.5 text-emerald-400 text-xs font-medium">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        You're in!
                    </div>

                    {{-- Ticket Number --}}
                    <div>
                        <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Ticket</p>
                        <p class="text-5xl font-black text-white tracking-tight">#{{ $ticket->id }}</p>
                    </div>

                    {{-- Position & Wait --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-4" wire:poll.5s="refreshPosition">
                            <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Position</p>
                            <p class="text-3xl font-bold text-violet-400">{{ $position }}</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                            <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Est. Wait</p>
                            <p class="text-3xl font-bold text-indigo-400">{{ $estimatedWait ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="rounded-2xl bg-violet-500/5 border border-violet-500/15 p-4">
                        <p class="text-sm text-slate-300">
                            @if ($ticket->name)
                                <span class="font-medium text-white">{{ $ticket->name }}</span>,
                            @endif
                            your position updates in real-time. Keep this page open or bookmark the URL to check back
                            later.
                        </p>
                    </div>

                    {{-- Push Notification Prompt --}}
                    <div x-data="pushNotifications()" x-init="checkPermission()" x-show="!subscribed && permission !== 'denied'" class="rounded-2xl bg-indigo-500/10 border border-indigo-500/20 p-4 mt-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-indigo-500/20">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-white">Get Notified</p>
                                <p class="text-xs text-slate-400">Receive an alert when it's your turn.</p>
                            </div>
                            <button @click="subscribe()" class="ml-auto text-xs font-bold text-indigo-400 hover:text-indigo-300 transition">
                                Enable
                            </button>
                        </div>
                    </div>

                    {{-- Refresh button --}}
                    <button wire:click="refreshPosition"
                        class="text-xs text-violet-400/60 hover:text-violet-400 transition underline underline-offset-4 decoration-violet-400/20">
                        Refresh status
                    </button>

                    {{-- Subtle branding --}}
                    <p class="text-xs text-slate-600">Powered by QRQ</p>
                </div>
            @else
                {{-- ══════════ JOIN FORM ══════════ --}}
                <form wire:submit="join" class="p-6 space-y-5">

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Your Name <span
                                class="text-slate-500">(optional)</span></label>
                        <input wire:model="name" type="text" id="name" placeholder="e.g. John Doe"
                            class="w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition">
                        @error('name')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone (optional) --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-1.5">
                            Phone <span class="text-slate-500">(optional, for SMS)</span>
                        </label>
                        <input wire:model="phone" type="tel" id="phone" placeholder="e.g. +94 77 123 4567"
                            class="w-full rounded-xl bg-white/5 border border-white/10 px-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full relative rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="join">Join Queue</span>
                        <span wire:loading wire:target="join" class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Joining…
                        </span>
                    </button>

                </form>
            @endif

        </div>

    </div>
</div>

<script>
    function pushNotifications() {
        return {
            subscribed: false,
            permission: 'default',
            vapidPublicKey: "{{ env('VAPID_PUBLIC_KEY') }}",

            checkPermission() {
                this.permission = Notification.permission;
                if (this.permission === 'granted') {
                    navigator.serviceWorker.ready.then(reg => {
                        reg.pushManager.getSubscription().then(sub => {
                            this.subscribed = !!sub;
                        });
                    });
                }
            },

            async subscribe() {
                if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                    alert('Push notifications are not supported in this browser.');
                    return;
                }

                try {
                    const status = await Notification.requestPermission();
                    this.permission = status;

                    if (status !== 'granted') return;

                    let registration = await navigator.serviceWorker.getRegistration();
                    if (!registration) {
                        registration = await navigator.serviceWorker.register('/service-worker.js');
                    }

                    const subscription = await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: this.urlBase64ToUint8Array(this.vapidPublicKey)
                    });

                    await @this.call('savePushSubscription', subscription.toJSON());
                    this.subscribed = true;
                } catch (error) {
                    console.error('Subscription failed:', error);
                }
            },

            urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding)
                    .replace(/\-/g, '+')
                    .replace(/_/g, '/');
                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);
                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }
                return outputArray;
            }
        }
    }
</script>
