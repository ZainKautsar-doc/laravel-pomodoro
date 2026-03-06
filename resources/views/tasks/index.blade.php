@extends('layouts.app', ['title' => 'Pomodoro Task Manager'])

@section('content')
<div class="flex flex-col items-center w-full space-y-12">
    <!-- Pomodoro Timer Card (Glass Style) -->
    <section class="w-full max-w-2xl bg-white/60 backdrop-blur-xl border border-white/40 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-indigo-900/10 relative overflow-hidden transition-all duration-500">
        <!-- Mode Tabs -->
        <div class="flex justify-center mb-12">
            <div class="inline-flex p-1.5 bg-white/40 backdrop-blur-md rounded-2xl border border-white/40 shadow-inner">
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
                <p class="text-slate-500 font-bold tracking-wide flex items-center gap-2">
                    Pomodoros completed before long break 
                    <span id="pomodoroCount" class="text-indigo-600">0</span>/4
                </p>

                <!-- Progress Bar -->
                <div class="w-full max-w-md h-2 bg-white/40 rounded-full overflow-hidden shadow-inner border border-white/20">
                    <div id="progressBar" class="h-full bg-indigo-500 rounded-full transition-all duration-1000 ease-linear shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Timer Controls -->
        <div class="flex items-center justify-center gap-6 mt-12">
            <button id="mainBtn"
                class="group relative flex items-center justify-center px-12 py-4 bg-[#4f46e5] hover:bg-[#4338ca] text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-500/30 transition-all duration-300 hover:scale-105 active:scale-95">
                <span id="mainBtnText">Start</span>
            </button>
            <button id="resetBtn"
                class="px-6 py-4 text-slate-400 hover:text-indigo-600 font-bold text-lg transition-all duration-300 hover:scale-105">
                Reset
            </button>
        </div>
    </section>

    <!-- Task Manager Section -->
    <section class="w-full max-w-4xl space-y-8">
        <div class="flex items-center justify-between px-4">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Focus Tasks</h3>
            <div class="h-px flex-grow mx-6 bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>
        </div>

        <div class="grid gap-6">
            @forelse ($tasks as $task)
            @php
            $statusStyles = [
                'todo' => 'bg-slate-100/80 text-slate-500 border-slate-200/50',
                'in_progress' => 'bg-indigo-100/80 text-indigo-600 border-indigo-200/50',
                'done' => 'bg-emerald-100/80 text-emerald-600 border-emerald-200/50',
            ][$task->status];
            @endphp

            <article class="group relative bg-white/70 backdrop-blur-lg border border-white/50 p-6 rounded-[2rem] shadow-lg shadow-indigo-900/5 hover:shadow-2xl hover:shadow-indigo-900/10 hover:-translate-y-1.5 transition-all duration-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <h4 class="text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors duration-300">{{ $task->title }}</h4>
                            <span class="text-[10px] uppercase tracking-widest font-black px-3 py-1 rounded-full border {{ $statusStyles }}">
                                {{ str_replace('_', ' ', $task->status) }}
                            </span>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-xl">
                            {{ $task->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between md:justify-end gap-8">
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-1">Deadline</p>
                            <p class="text-sm font-bold text-slate-600">
                                {{ $task->deadline ? $task->deadline->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            @if ($task->status !== 'done')
                            <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Complete Task"
                                    class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-emerald-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('tasks.edit', $task) }}" title="Edit Task"
                                class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Task"
                                    class="p-3 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-rose-500/30">
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
            <div class="bg-white/40 border-2 border-dashed border-white/60 p-16 rounded-[2.5rem] text-center backdrop-blur-md">
                <p class="text-slate-500 font-bold text-lg">Your focus list is empty.</p>
                <p class="text-slate-400 text-sm mt-1">Ready to start something new?</p>
            </div>
            @endforelse
        </div>
    </section>
</div>

<!-- Floating Action Button -->
<a href="{{ route('tasks.create') }}"
    class="fixed bottom-10 right-10 z-50 flex items-center gap-3 px-8 py-5 bg-[#4f46e5] hover:bg-[#4338ca] text-white rounded-[2rem] font-bold shadow-2xl shadow-indigo-500/40 transition-all duration-300 hover:scale-110 active:scale-95 group">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
    </svg>
    <span>Add New Task</span>
</a>

<script>
    (() => {
        const modes = {
            pomodoro: { seconds: 25 * 60 },
            shortBreak: { seconds: 5 * 60 },
            longBreak: { seconds: 15 * 60 },
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
                    
                    updateUI();

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
                    tab.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
                    tab.classList.remove('text-slate-500');
                } else {
                    tab.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
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
