<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenants\AppController;

Route::get('/app', [AppController::class, 'index'])->name('app.index');
Route::post('/app', [AppController::class, 'store'])->name('app.store');
