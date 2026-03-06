@extends('layouts.app', ['title' => 'Buat Task'])

@section('content')
    <section class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="mb-6 text-xl font-semibold text-slate-900">Buat Task Baru</h2>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            @include('tasks._form')
        </form>
    </section>
@endsection

