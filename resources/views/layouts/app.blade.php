<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Task Manager Pomodoro' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-teal-50 to-green-100 text-slate-800 antialiased">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -left-16 top-8 h-48 w-48 rounded-full bg-emerald-200/50 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 h-56 w-56 rounded-full bg-teal-200/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-green-200/40 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-3xl border border-white/50 bg-white/45 p-5 shadow-lg shadow-emerald-900/5 backdrop-blur-xl">
            <div>
                <p class="text-sm font-medium text-emerald-700">Focus Study Workspace</p>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">Task Manager & Pomodoro</h1>
            </div>
            <a href="{{ route('tasks.create') }}"
               class="inline-flex items-center rounded-2xl border border-emerald-500/20 bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-emerald-900/15 transition hover:scale-[1.02] hover:shadow-xl">
                Buat Task Baru
            </a>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200/70 bg-white/70 px-4 py-3 text-sm text-emerald-700 shadow-md shadow-emerald-900/5 backdrop-blur">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
