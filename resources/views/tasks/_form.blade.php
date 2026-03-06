@php
    $isEdit = isset($task);
@endphp

<div class="space-y-5">
    <div>
        <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
        <input type="text"
               id="title"
               name="title"
               value="{{ old('title', $task->title ?? '') }}"
               class="w-full rounded-2xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
               placeholder="Contoh: Belajar Laravel Eloquent"
               required>
        @error('title')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
        <textarea id="description"
                  name="description"
                  rows="4"
                  class="w-full rounded-2xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                  placeholder="Detail belajar yang perlu diselesaikan">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($isEdit)
        <div>
            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
            <select id="status"
                    name="status"
                    class="w-full rounded-2xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                    required>
                <option value="todo" @selected(old('status', $task->status) === 'todo')>Todo</option>
                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
                <option value="done" @selected(old('status', $task->status) === 'done')>Done</option>
            </select>
            @error('status')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label for="deadline" class="mb-1 block text-sm font-medium text-slate-700">Deadline</label>
        <input type="date"
               id="deadline"
               name="deadline"
               value="{{ old('deadline', isset($task->deadline) ? $task->deadline->format('Y-m-d') : '') }}"
               class="w-full rounded-2xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
        @error('deadline')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2 text-sm font-medium text-white shadow-md shadow-emerald-900/10 transition hover:shadow-lg">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Task' }}
        </button>
        <a href="{{ route('tasks.index') }}"
           class="inline-flex items-center rounded-2xl border border-emerald-200 bg-white/80 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50">
            Batal
        </a>
    </div>
</div>
