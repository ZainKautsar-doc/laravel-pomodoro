<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Task Manager Pomodoro' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-blue-600">Study Productivity</p>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">Task Manager & Pomodoro</h1>
            </div>
            <a href="{{ route('tasks.create') }}"
               class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                Buat Task Baru
            </a>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

