@php
    $isEdit = isset($task);
@endphp

<div class="space-y-6">
    <div class="group">
        <label for="title" class="mb-2 block text-sm font-bold text-slate-700 tracking-wide">Task Title</label>
        <input type="text"
               id="title"
               name="title"
               value="{{ old('title', $task->title ?? '') }}"
               class="w-full rounded-2xl border border-white/60 bg-white/50 px-5 py-3.5 text-sm shadow-sm outline-none transition-all duration-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100 placeholder:text-slate-400"
               placeholder="What needs to be done?"
               required>
        @error('title')
            <p class="mt-2 text-xs font-bold text-rose-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-bold text-slate-700 tracking-wide">Description</label>
        <textarea id="description"
                  name="description"
                  rows="4"
                  class="w-full rounded-2xl border border-white/60 bg-white/50 px-5 py-3.5 text-sm shadow-sm outline-none transition-all duration-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100 placeholder:text-slate-400"
                  placeholder="Add some details about this task...">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-xs font-bold text-rose-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if ($isEdit)
            <div>
                <label for="status" class="mb-2 block text-sm font-bold text-slate-700 tracking-wide">Status</label>
                <div class="relative">
                    <select id="status"
                            name="status"
                            class="w-full appearance-none rounded-2xl border border-white/60 bg-white/50 px-5 py-3.5 text-sm shadow-sm outline-none transition-all duration-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                            required>
                        <option value="todo" @selected(old('status', $task->status) === 'todo')>Todo</option>
                        <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                        <option value="done" @selected(old('status', $task->status) === 'done')>Done</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 7.293 8.172 5.879 9.586z"/></svg>
                    </div>
                </div>
                @error('status')
                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <div>
            <label for="deadline" class="mb-2 block text-sm font-bold text-slate-700 tracking-wide">Deadline</label>
            <input type="date"
                   id="deadline"
                   name="deadline"
                   value="{{ old('deadline', isset($task->deadline) ? $task->deadline->format('Y-m-d') : '') }}"
                   class="w-full rounded-2xl border border-white/60 bg-white/50 px-5 py-3.5 text-sm shadow-sm outline-none transition-all duration-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            @error('deadline')
                <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center gap-4 pt-6">
        <button type="submit"
                class="flex-grow md:flex-none px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/30 transition-all duration-300 hover:scale-[1.02] active:scale-95">
            {{ $isEdit ? 'Save Changes' : 'Create Task' }}
        </button>
        <a href="{{ route('tasks.index') }}"
           class="px-8 py-4 bg-white/60 hover:bg-white/80 text-slate-600 rounded-2xl font-bold text-sm border border-white/60 transition-all duration-300 hover:scale-[1.02] active:scale-95 text-center">
            Cancel
        </a>
    </div>
</div>
