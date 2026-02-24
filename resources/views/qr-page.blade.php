<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code – {{ $queue->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 flex items-center justify-center p-6 antialiased">

    <div class="text-center space-y-8 max-w-sm mx-auto">
        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">{{ $queue->business->name }}</h1>
            <p class="text-slate-400 mt-1">{{ $queue->name }} Queue</p>
        </div>

        {{-- QR Code Card --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl inline-block">
            <img src="{{ $qrUrl }}" alt="QR Code to join queue" class="w-64 h-64 mx-auto">
        </div>

        {{-- Instructions --}}
        <div class="space-y-3">
            <p class="text-slate-300 text-sm">Scan the QR code to join the queue</p>
            <p class="text-xs text-slate-500">or visit</p>
            <a href="{{ $joinUrl }}"
                class="inline-block text-sm text-violet-400 hover:text-violet-300 underline underline-offset-4 decoration-violet-400/30 hover:decoration-violet-300/50 transition break-all">
                {{ $joinUrl }}
            </a>
        </div>

        <p class="text-xs text-slate-600">Powered by QRQ</p>
    </div>

</body>

</html>
