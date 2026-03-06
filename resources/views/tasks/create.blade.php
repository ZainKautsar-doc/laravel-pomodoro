@extends('layouts.app', ['title' => 'Buat Task'])

@section('content')
    <section class="mx-auto max-w-3xl rounded-3xl border border-white/60 bg-white/60 p-6 shadow-xl shadow-emerald-900/10 backdrop-blur-xl sm:p-8">
        <h2 class="mb-6 text-xl font-semibold text-slate-900">Buat Task Baru</h2>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            @include('tasks._form')
        </form>
    </section>
@endsection
