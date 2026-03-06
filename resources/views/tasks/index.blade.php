@extends('layouts.app', ['title' => 'Dashboard Task Manager'])

@section('content')
    <div class="grid gap-6 lg:grid-cols-12">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-4 lg:sticky lg:top-8 lg:h-fit">
            <p class="text-sm font-medium text-blue-600">Pomodoro Study Timer</p>
            <h2 class="mt-1 text-xl font-semibold text-slate-900">Focus Session</h2>
            <p class="mt-2 text-sm text-slate-500">Gunakan sesi 25 menit untuk belajar lebih fokus.</p>

            <div class="mt-6 rounded-2xl bg-slate-50 p-6 text-center">
                <p id="timerDisplay" class="text-5xl font-semibold tracking-tight text-slate-900">25:00</p>
                <p id="timerState" class="mt-2 text-sm text-slate-500">Siap mulai</p>
            </div>

            <div class="mt-5 grid grid-cols-3 gap-2">
                <button id="startBtn"
                        class="rounded-xl bg-blue-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    Start
                </button>
                <button id="pauseBtn"
                        class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    Pause
                </button>
                <button id="resetBtn"
                        class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    Reset
                </button>
            </div>
        </section>

        <section class="space-y-4 lg:col-span-8">
            @forelse ($tasks as $task)
                @php
                    $statusConfig = [
                        'todo' => ['label' => 'Todo', 'class' => 'bg-slate-100 text-slate-700'],
                        'in_progress' => ['label' => 'In Progress', 'class' => 'bg-blue-100 text-blue-700'],
                        'done' => ['label' => 'Done', 'class' => 'bg-emerald-100 text-emerald-700'],
                    ][$task->status];
                @endphp

                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
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
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus task ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm text-slate-500">Belum ada task. Klik <span class="font-medium text-slate-700">Buat Task Baru</span> untuk memulai.</p>
                </div>
            @endforelse
        </section>
    </div>

    <script>
        (() => {
            const totalSeconds = 25 * 60;
            let remaining = totalSeconds;
            let intervalId = null;

            const timerDisplay = document.getElementById('timerDisplay');
            const timerState = document.getElementById('timerState');
            const startBtn = document.getElementById('startBtn');
            const pauseBtn = document.getElementById('pauseBtn');
            const resetBtn = document.getElementById('resetBtn');

            const render = () => {
                const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
                const seconds = String(remaining % 60).padStart(2, '0');
                timerDisplay.textContent = `${minutes}:${seconds}`;
            };

            const stop = () => {
                if (!intervalId) {
                    return;
                }
                clearInterval(intervalId);
                intervalId = null;
            };

            startBtn.addEventListener('click', () => {
                if (intervalId) {
                    return;
                }
                timerState.textContent = 'Sedang fokus...';
                intervalId = setInterval(() => {
                    if (remaining <= 0) {
                        stop();
                        timerState.textContent = 'Sesi selesai';
                        alert('Pomodoro selesai! Saatnya istirahat sejenak.');
                        return;
                    }
                    remaining -= 1;
                    render();
                }, 1000);
            });

            pauseBtn.addEventListener('click', () => {
                stop();
                timerState.textContent = 'Dijeda';
            });

            resetBtn.addEventListener('click', () => {
                stop();
                remaining = totalSeconds;
                render();
                timerState.textContent = 'Siap mulai';
            });

            render();
        })();
    </script>
@endsection
