@extends('layouts.app', ['title' => 'Dashboard Task Manager'])

@section('content')
<a href="{{ route('tasks.create') }}"
    class="fixed bottom-8 right-8 z-50 inline-flex items-center rounded-full border border-emerald-500/20 bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4 text-sm font-semibold text-white shadow-xl shadow-emerald-900/20 transition hover:-translate-y-1 hover:shadow-2xl">
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
    </svg>
    Buat Task Baru
</a>

<div class="grid gap-6 lg:grid-cols-12">
    <section class="rounded-3xl border border-white/50 bg-white/50 p-5 shadow-xl shadow-emerald-900/10 backdrop-blur-xl sm:p-7 lg:col-span-5 lg:sticky lg:top-8 lg:h-fit">
        <p class="text-sm font-medium text-emerald-700">Pomodoro Study Timer</p>
        <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Deep Focus Session</h2>
        <p class="mt-2 text-sm text-slate-600">Gunakan mode fokus dan break agar ritme belajar tetap stabil.</p>

        <div class="mt-6 rounded-3xl border border-emerald-100/70 bg-white/70 p-3">
            <div id="modeTabs" class="grid grid-cols-3 gap-2">
                <button type="button" data-mode="pomodoro"
                    class="mode-tab rounded-2xl bg-emerald-500 px-3 py-2 text-xs font-semibold text-white shadow-md shadow-emerald-900/15 transition sm:text-sm">
                    Pomodoro
                </button>
                <button type="button" data-mode="shortBreak"
                    class="mode-tab rounded-2xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 sm:text-sm">
                    Short Break
                </button>
                <button type="button" data-mode="longBreak"
                    class="mode-tab rounded-2xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 sm:text-sm">
                    Long Break
                </button>
            </div>
        </div>

        <div class="mt-6 flex flex-col items-center justify-center rounded-3xl border border-white/70 bg-white/60 px-6 py-10 shadow-inner shadow-emerald-900/5">
            <div class="relative flex items-center justify-center">
                <svg class="h-64 w-64 -rotate-90 transform">
                    <circle cx="128" cy="128" r="120" stroke="currentColor" stroke-width="8" fill="transparent" class="text-emerald-100/50" />
                    <circle id="timerProgressCircle" cx="128" cy="128" r="120" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="753.98" stroke-dashoffset="0" class="text-emerald-500 transition-all duration-1000 ease-linear" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <p id="timerDisplay" class="text-6xl font-semibold tracking-tight text-slate-900 sm:text-7xl">00:00</p>
                    <p id="timerState" class="mt-2 text-sm text-slate-500">Memuat...</p>
                </div>
            </div>
        </div>

        <div class="mt-5 grid grid-cols-3 gap-2">
            <button id="startBtn"
                class="rounded-2xl bg-emerald-500 px-3 py-2.5 text-sm font-semibold text-white shadow-md shadow-emerald-900/15 transition hover:bg-emerald-600">
                Start
            </button>
            <button id="pauseBtn"
                class="rounded-2xl border border-emerald-200 bg-white/80 px-3 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                Pause
            </button>
            <button id="resetBtn"
                class="rounded-2xl border border-emerald-200 bg-white/80 px-3 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                Reset
            </button>
        </div>

        <div class="mt-5 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-sm text-emerald-900">
            <p class="font-medium">Pomodoros completed before long break</p>
            <p class="mt-1 text-lg font-semibold">
                <span id="pomodoroCount">0</span> / 4
            </p>
            <p id="longBreakHint" class="mt-1 text-xs text-emerald-700">Selesaikan 4 pomodoro untuk rekomendasi long break.</p>
        </div>
    </section>

    <section class="space-y-4 lg:col-span-7">
        @forelse ($tasks as $task)
        @php
        $statusConfig = [
        'todo' => ['label' => 'Todo', 'class' => 'bg-slate-100 text-slate-700'],
        'in_progress' => ['label' => 'In Progress', 'class' => 'bg-blue-100 text-blue-700'],
        'done' => ['label' => 'Done', 'class' => 'bg-emerald-100 text-emerald-700'],
        ][$task->status];
        @endphp

        <article class="rounded-3xl border border-white/60 bg-white/60 p-5 shadow-lg shadow-emerald-900/10 backdrop-blur-xl transition hover:-translate-y-0.5 hover:shadow-xl">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <h3 class="text-lg font-semibold text-slate-900">{{ $task->title }}</h3>
                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $statusConfig['class'] }}">
                    {{ $statusConfig['label'] }}
                </span>
            </div>

            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                {{ $task->description ?: 'Tidak ada deskripsi.' }}
            </p>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-slate-500">
                    Deadline:
                    <span class="font-medium text-slate-700">
                        {{ $task->deadline ? $task->deadline->format('d M Y') : 'Tidak ditentukan' }}
                    </span>
                </p>

                <div class="flex items-center gap-2">
                    @if ($task->status !== 'done')
                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center rounded-xl border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('tasks.edit', $task) }}"
                        class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus task ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </article>
        @empty
        <div class="rounded-3xl border border-dashed border-emerald-200 bg-white/60 p-8 text-center shadow-md shadow-emerald-900/5 backdrop-blur-xl">
            <p class="text-sm text-slate-500">Belum ada task. Klik <span class="font-medium text-slate-700">Buat Task Baru</span> untuk memulai.</p>
        </div>
        @endforelse
    </section>
</div>

<script>
    (() => {
        const modes = {
            pomodoro: {
                label: 'Pomodoro',
                seconds: 25 * 60
            },
            shortBreak: {
                label: 'Short Break',
                seconds: 5 * 60
            },
            longBreak: {
                label: 'Long Break',
                seconds: 15 * 60
            },
        };

        let currentMode = 'pomodoro';
        let totalSeconds = modes[currentMode].seconds;
        let remaining = totalSeconds;
        let intervalId = null;
        let pomodoroCount = Number(localStorage.getItem('pomodoro_count') || 0);

        const timerDisplay = document.getElementById('timerDisplay');
        const timerState = document.getElementById('timerState');
        const timerProgressCircle = document.getElementById('timerProgressCircle');
        const startBtn = document.getElementById('startBtn');
        const pauseBtn = document.getElementById('pauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        const modeTabs = document.querySelectorAll('.mode-tab');
        const pomodoroCountEl = document.getElementById('pomodoroCount');
        const longBreakHint = document.getElementById('longBreakHint');

        const renderCounter = () => {
            pomodoroCountEl.textContent = pomodoroCount % 4;
            if (pomodoroCount > 0 && pomodoroCount % 4 === 0) {
                longBreakHint.textContent = 'Sudah 4 pomodoro, disarankan ambil Long Break.';
            } else {
                longBreakHint.textContent = 'Selesaikan 4 pomodoro untuk rekomendasi long break.';
            }
        };

        const render = () => {
            const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
            const seconds = String(remaining % 60).padStart(2, '0');
            timerDisplay.textContent = `${minutes}:${seconds}`;
            const percent = remaining / totalSeconds;
            timerProgressCircle.style.strokeDashoffset = (1 - percent) * 753.98;
        };

        const stop = () => {
            if (!intervalId) {
                return;
            }
            clearInterval(intervalId);
            intervalId = null;
        };

        const setMode = (mode) => {
            currentMode = mode;
            totalSeconds = modes[mode].seconds;
            remaining = totalSeconds;
            stop();
            timerState.textContent = `Siap mulai mode ${modes[mode].label}`;

            modeTabs.forEach((tab) => {
                if (tab.dataset.mode === mode) {
                    tab.classList.remove('bg-emerald-50', 'text-emerald-700');
                    tab.classList.add('bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-900/15');
                } else {
                    tab.classList.remove('bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-900/15');
                    tab.classList.add('bg-emerald-50', 'text-emerald-700');
                }
            });

            render();
        };

        modeTabs.forEach((tab) => {
            tab.addEventListener('click', () => setMode(tab.dataset.mode));
        });

        startBtn.addEventListener('click', () => {
            if (intervalId) {
                return;
            }

            timerState.textContent = `Sedang berjalan: ${modes[currentMode].label}`;
            intervalId = setInterval(() => {
                if (remaining <= 0) {
                    stop();

                    if (currentMode === 'pomodoro') {
                        pomodoroCount += 1;
                        localStorage.setItem('pomodoro_count', String(pomodoroCount));
                        renderCounter();
                    }

                    timerState.textContent = `${modes[currentMode].label} selesai`;
                    alert(currentMode === 'pomodoro' ?
                        'Pomodoro selesai! Waktunya istirahat sejenak.' :
                        'Break selesai! Siap kembali fokus.');

                    if (currentMode === 'pomodoro' && pomodoroCount % 4 === 0) {
                        alert('Anda sudah menyelesaikan 4 Pomodoro. Disarankan Long Break 15 menit.');
                    }

                    return;
                }

                remaining -= 1;
                render();
            }, 1000);
        });

        pauseBtn.addEventListener('click', () => {
            stop();
            timerState.textContent = 'Timer dijeda';
        });

        resetBtn.addEventListener('click', () => {
            stop();
            remaining = totalSeconds;
            render();
            timerState.textContent = `Reset ke mode ${modes[currentMode].label}`;
        });

        renderCounter();
        setMode(currentMode);
    })();
</script>
@endsection