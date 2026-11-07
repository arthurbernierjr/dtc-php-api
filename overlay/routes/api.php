<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['ok' => true]));

Route::apiResource('todos', TodoController::class)->where(['todo' => '[0-9]+']);
