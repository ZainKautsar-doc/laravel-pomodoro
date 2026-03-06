@extends('layouts.app', ['title' => 'Edit Task'])

@section('content')
<div class="flex flex-col items-center w-full">
    <section class="w-full max-w-2xl bg-white/40 backdrop-blur-2xl border border-white/40 rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/10 relative overflow-hidden transition-all duration-500">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('tasks.index') }}" class="p-2 bg-white/50 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Edit Task</h2>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            @include('tasks._form')
        </form>
    </section>
</div>
@endsection
