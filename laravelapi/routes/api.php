<?php

use App\Http\Controllers\API\TodoController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('todos', [TodoController::class, 'index']);
Route::post('/add-todo', [TodoController::class, 'store']);
Route::get('/edit-todo/{id}', [TodoController::class, 'edit']);
Route::put('update-todo/{id}', [TodoController::class, 'update']);
Route::delete('delete-todo/{id}', [TodoController::class, 'destroy']);
// Route::put('complete-todo/{id}', [TodoController::class, 'complete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
