<?php

use Illuminate\Support\Facades\Route;
use Aristides\Multitenancy\Http\Controllers\AppController;

Route::get('/app', [AppController::class, 'index'])->name('app.index');
Route::post('/app', [AppController::class, 'store'])->name('app.store');
