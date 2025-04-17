<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', [AuthController::class, 'showLogin'])->name('auth');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/tasks', [TaskController::class, 'showTasks'])->name('tasks.show');
    Route::get('/tasks/create', [TaskController::class, 'createTask'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'storeTask'])->name('tasks.store');
    Route::post('/tasks/update', [TaskController::class, 'updateTask'])->name('tasks.update');
    Route::post('/tasks/updateStatus', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});