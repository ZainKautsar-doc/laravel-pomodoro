<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('tasks.index'));
Route::resource('tasks', TaskController::class)->except(['show']);
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
Route::patch('/tasks/{task}/start', [TaskController::class, 'start'])->name('tasks.start');
