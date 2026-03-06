@extends('layouts.app', ['title' => 'Edit Task'])

@section('content')
    <section class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="mb-6 text-xl font-semibold text-slate-900">Edit Task</h2>
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            @include('tasks._form')
        </form>
    </section>
@endsection

