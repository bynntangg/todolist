<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggleStatus'])->name('todos.toggle');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

