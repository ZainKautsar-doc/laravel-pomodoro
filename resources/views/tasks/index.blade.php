@extends('layouts.app', ['title' => 'Pomodoro Task Manager'])

@section('content')
<div class="flex flex-col items-center w-full space-y-12">
    <!-- Pomodoro Timer Card -->
    <section class="w-full max-w-2xl bg-white/40 backdrop-blur-2xl border border-white/40 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/10 relative overflow-hidden transition-all duration-500">
        <!-- Mode Tabs -->
        <div class="flex justify-center mb-12">
            <div class="inline-flex p-1.5 bg-white/30 backdrop-blur-md rounded-2xl border border-white/40 shadow-inner">
                <button type="button" data-mode="pomodoro"
                    class="mode-tab px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Pomodoro
                </button>
                <button type="button" data-mode="shortBreak"
                    class="mode-tab px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Short Break
                </button>
                <button type="button" data-mode="longBreak"
                    class="mode-tab px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300">
                    Long Break
                </button>
            </div>
        </div>

        <!-- Timer Display -->
        <div class="flex flex-col items-center justify-center space-y-8 relative">
            <h2 id="timerDisplay" class="text-8xl md:text-9xl font-black tracking-tight text-slate-800 drop-shadow-sm transition-all duration-500 tabular-nums">
                25:00
            </h2>

            <div class="space-y-4 w-full flex flex-col items-center">
                <p class="text-slate-400 font-bold tracking-wide flex items-center gap-2">
                    Pomodoros completed before long break 
                    <span id="pomodoroCount">0</span>/4
                </p>

                <!-- Progress Bar -->
                <div class="w-full max-w-md h-1.5 bg-white/30 rounded-full overflow-hidden shadow-inner">
                    <div id="progressBar" class="h-full bg-blue-500/80 rounded-full transition-all duration-1000 ease-linear" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Timer Controls -->
        <div class="flex items-center justify-center gap-6 mt-12">
            <button id="mainBtn"
                class="group relative flex items-center justify-center px-12 py-4 bg-slate-800 hover:bg-slate-900 text-white rounded-[1.5rem] font-bold text-lg shadow-xl shadow-slate-900/10 transition-all duration-300 hover:scale-105 active:scale-95">
                <span id="mainBtnText">Start</span>
            </button>
            <button id="resetBtn"
                class="px-6 py-4 text-slate-400 hover:text-slate-600 font-bold text-lg transition-all duration-300">
                Reset
            </button>
        </div>
    </section>

    <!-- Task Manager Section -->
    <section class="w-full max-w-4xl space-y-6">
        <div class="flex items-center justify-between px-4">
            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Tasks</h3>
            <div class="h-px flex-grow mx-6 bg-gradient-to-r from-slate-200/0 via-slate-200 to-slate-200/0"></div>
        </div>

        <div class="grid gap-4">
            @forelse ($tasks as $task)
            @php
            $statusStyles = [
                'todo' => 'bg-slate-100 text-slate-500 border-slate-200',
                'in_progress' => 'bg-blue-100 text-blue-600 border-blue-200',
                'done' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
            ][$task->status];
            @endphp

            <article class="group relative bg-white/50 backdrop-blur-lg border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <h4 class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $task->title }}</h4>
                            <span class="text-[10px] uppercase tracking-widest font-bold px-2.5 py-1 rounded-full border {{ $statusStyles }}">
                                {{ str_replace('_', ' ', $task->status) }}
                            </span>
                        </div>
                        <p class="text-slate-500 text-sm line-clamp-1 group-hover:line-clamp-none transition-all duration-300">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between md:justify-end gap-6">
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Deadline</p>
                            <p class="text-sm font-bold text-slate-600">
                                {{ $task->deadline ? $task->deadline->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($task->status !== 'done')
                            <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Complete Task"
                                    class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('tasks.edit', $task) }}" title="Edit Task"
                                class="p-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-500 hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Task"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-500 hover:text-white transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="bg-white/30 border-2 border-dashed border-white/60 p-12 rounded-[2.5rem] text-center">
                <p class="text-slate-400 font-medium">No tasks yet. Create one to get started!</p>
            </div>
            @endforelse
        </div>
    </section>
</div>

<!-- Floating Action Button -->
<a href="{{ route('tasks.create') }}"
    class="fixed bottom-10 right-10 z-50 flex items-center gap-3 px-6 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-2xl shadow-blue-500/40 transition-all duration-300 hover:scale-105 active:scale-95 group">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
    </svg>
    <span>Add New Task</span>
</a>

<script>
    (() => {
        const modes = {
            pomodoro: { seconds: 25 * 60, theme: 'blue' },
            shortBreak: { seconds: 5 * 60, theme: 'sky' },
            longBreak: { seconds: 15 * 60, theme: 'cyan' },
        };

        let currentMode = 'pomodoro';
        let totalSeconds = modes[currentMode].seconds;
        let remaining = totalSeconds;
        let intervalId = null;
        let pomodoroCount = Number(localStorage.getItem('pomodoro_count') || 0);

        const timerDisplay = document.getElementById('timerDisplay');
        const progressBar = document.getElementById('progressBar');
        const mainBtn = document.getElementById('mainBtn');
        const mainBtnText = document.getElementById('mainBtnText');
        const resetBtn = document.getElementById('resetBtn');
        const modeTabs = document.querySelectorAll('.mode-tab');
        const pomodoroCountEl = document.getElementById('pomodoroCount');

        const updateUI = () => {
            const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
            const seconds = String(remaining % 60).padStart(2, '0');
            timerDisplay.textContent = `${minutes}:${seconds}`;
            
            const percent = (remaining / totalSeconds) * 100;
            progressBar.style.width = `${percent}%`;
            
            // Show 1-4, or 0 if none completed yet in current cycle
            const displayCount = pomodoroCount % 4 === 0 && pomodoroCount > 0 ? 4 : pomodoroCount % 4;
            pomodoroCountEl.textContent = displayCount;
            
            // Update document title
            document.title = `${minutes}:${seconds} - ${currentMode.charAt(0).toUpperCase() + currentMode.slice(1)}`;
        };

        const stopTimer = () => {
            if (intervalId) {
                clearInterval(intervalId);
                intervalId = null;
                mainBtnText.textContent = 'Start';
            }
        };

        const startTimer = () => {
            if (intervalId) return;
            
            mainBtnText.textContent = 'Pause';
            intervalId = setInterval(() => {
                if (remaining <= 0) {
                    stopTimer();
                    if (currentMode === 'pomodoro') {
                        pomodoroCount++;
                        localStorage.setItem('pomodoro_count', pomodoroCount);
                    }
                    
                    updateUI(); // update the counter UI before alerts

                    const message = currentMode === 'pomodoro' 
                        ? 'Pomodoro finished! Time for a break.' 
                        : 'Break finished! Back to focus.';
                    
                    alert(message);
                    
                    if (currentMode === 'pomodoro' && pomodoroCount % 4 === 0) {
                        alert('You completed 4 Pomodoros! Take a long break.');
                    }
                    return;
                }
                remaining--;
                updateUI();
            }, 1000);
        };

        const setMode = (mode) => {
            stopTimer();
            currentMode = mode;
            totalSeconds = modes[mode].seconds;
            remaining = totalSeconds;
            
            modeTabs.forEach(tab => {
                if (tab.dataset.mode === mode) {
                    tab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                    tab.classList.remove('text-slate-500');
                } else {
                    tab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                    tab.classList.add('text-slate-500');
                }
            });

            updateUI();
        };

        mainBtn.addEventListener('click', () => {
            if (intervalId) stopTimer();
            else startTimer();
        });

        resetBtn.addEventListener('click', () => {
            stopTimer();
            remaining = totalSeconds;
            updateUI();
        });

        modeTabs.forEach(tab => {
            tab.addEventListener('click', () => setMode(tab.dataset.mode));
        });

        // Initialize
        setMode('pomodoro');
    })();
</script>
@endsection
