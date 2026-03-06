<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Task Manager Pomodoro' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#dbeafe] via-[#bfdbfe] to-[#818cf8] text-[#1e293b] antialiased selection:bg-indigo-200 selection:text-indigo-900 font-sans">
    <!-- Subtle Noise Texture Overlay -->
    <div class="pointer-events-none fixed inset-0 z-50 opacity-[0.03] mix-blend-overlay" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.65\' numOctaves=\'3\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E');"></div>

    <div class="relative mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="fixed top-8 left-1/2 -translate-x-1/2 z-[60] animate-fade-in-down">
                <div class="rounded-2xl border border-white/40 bg-white/80 px-6 py-3 text-sm font-bold text-indigo-800 shadow-xl shadow-indigo-900/10 backdrop-blur-md">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
