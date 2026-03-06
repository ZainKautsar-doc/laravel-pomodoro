<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Task Manager Pomodoro' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-sky-100 to-cyan-100 text-slate-800 antialiased selection:bg-blue-200 selection:text-blue-900">
    <!-- Soft Background Gradients -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden -z-10">
        <div class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-blue-200/40 blur-[100px]"></div>
        <div class="absolute right-0 top-1/4 h-[600px] w-[600px] rounded-full bg-sky-200/30 blur-[120px]"></div>
        <div class="absolute bottom-0 left-1/4 h-[700px] w-[700px] rounded-full bg-cyan-200/40 blur-[150px]"></div>
    </div>

    <div class="relative mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="fixed top-8 left-1/2 -translate-x-1/2 z-[60] animate-fade-in-down">
                <div class="rounded-2xl border border-blue-200/50 bg-white/80 px-6 py-3 text-sm font-medium text-blue-800 shadow-xl shadow-blue-900/5 backdrop-blur-md">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
