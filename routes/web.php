<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\SchedulingController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Scheduling routes
Route::post('/schedule', [SchedulingController::class, 'schedule'])->name('schedule');
Route::get('/result', [SchedulingController::class, 'result']);

// Process routes
Route::post('/calculate', [ProcessController::class, 'calculate'])->name('calculate');
Route::get('/process', [ProcessController::class, 'index']);
Route::get('/', [ProcessController::class, 'index'])->name('welcome');
Route::view('/result', 'result')->name('result');
