<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->orderByRaw("
                CASE status
                    WHEN 'in_progress' THEN 1
                    WHEN 'todo' THEN 2
                    WHEN 'done' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('deadline')
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline' => ['nullable', 'date'],
        ]);

        Task::create([
            ...$validated,
            'status' => 'todo',
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task berhasil dibuat.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'deadline' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task berhasil dihapus.');
    }

    public function complete(Task $task): RedirectResponse
    {
        $task->update([
            'status' => 'done',
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task ditandai selesai.');
    }
}
