<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('tasks.index'));
Route::resource('tasks', TaskController::class)->except(['show']);
