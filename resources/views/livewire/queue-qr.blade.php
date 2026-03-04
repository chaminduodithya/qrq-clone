<div class="p-4 md:p-8">
    <div class="max-w-2xl mx-auto">

        {{-- Back button --}}
        <div class="mb-6">
            <a href="{{ route('business.queues', $queue->business->slug) }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Queues
            </a>
        </div>

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white">QR Code</h1>
            <p class="text-slate-400 text-sm mt-1">
                Customers can scan this code to join <span class="text-violet-400 font-medium">{{ $queue->name }}</span>
            </p>
        </div>

        {{-- QR Card --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 flex flex-col items-center gap-6" id="qr-card">

            {{-- Queue Name Badge --}}
            <div class="text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-violet-500/10 border border-violet-500/20 px-4 py-1.5 text-sm font-semibold text-violet-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                    {{ $queue->name }}
                </span>
            </div>

            {{-- QR Code --}}
            <div class="bg-white p-5 rounded-2xl shadow-2xl shadow-black/50 ring-4 ring-white/10">
                {!! QrCode::size(240)->generate(route('join.queue', $queue->slug)) !!}
            </div>

            {{-- Join URL --}}
            <div class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-center">
                <p class="text-xs text-slate-500 mb-1 uppercase tracking-widest font-medium">Scan or visit</p>
                <code class="text-violet-400 text-sm break-all">{{ route('join.queue', $queue->slug) }}</code>
            </div>

            {{-- Stats Row --}}
            <div class="w-full grid grid-cols-2 gap-4">
                <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-white">{{ $queue->tickets()->where('status', 'waiting')->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Waiting now</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-white">{{ $queue->tickets()->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Total tickets</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-3">

            {{-- Print QR Code --}}
            <button onclick="printQr()"
                class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.056 48.056 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                Print QR Code
            </button>

            {{-- Copy Link --}}
            <button onclick="copyLink('{{ route('join.queue', $queue->slug) }}')" id="copy-btn"
                class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-white/5 border border-white/10 px-5 py-3 text-sm font-semibold text-slate-300 hover:bg-white/10 hover:text-white transition-all duration-200">
                <svg class="w-4 h-4" id="copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                </svg>
                <span id="copy-text">Copy Link</span>
            </button>

            {{-- View Public Display --}}
            <a href="{{ route('display.queue', $queue->slug) }}" target="_blank"
                class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 px-5 py-3 text-sm font-semibold text-emerald-400 hover:bg-emerald-500/20 hover:text-emerald-300 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                </svg>
                Public Display ↗
            </a>
        </div>

    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            body * { visibility: hidden; }
            #qr-card, #qr-card * { visibility: visible; }
            #qr-card {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                color: black !important;
                padding: 30px !important;
                border-radius: 16px !important;
                width: auto !important;
            }
            #qr-card .bg-slate-900\/60 { background: #f4f4f4 !important; }
            #qr-card code { color: #7c3aed !important; }
            #qr-card p, #qr-card span { color: #1e293b !important; }
        }
    </style>

    {{-- JS Helpers --}}
    <script>
        function printQr() {
            window.print();
        }

        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.getElementById('copy-btn');
                const text = document.getElementById('copy-text');
                text.textContent = 'Copied!';
                btn.classList.add('bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-400');
                setTimeout(() => {
                    text.textContent = 'Copy Link';
                    btn.classList.remove('bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-400');
                }, 2000);
            });
        }
    </script>

</div>
