<?php

use Aristides\Multitenancy\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TenantController::class, 'index'])->name('tenant.index');
Route::post('store', [TenantController::class, 'store'])->name('tenant.store');
Route::post('migration', [TenantController::class, 'migration'])->name('tenant.migration');
Route::get('migration/{uuid}', [TenantController::class, 'migrationByUuid'])->name('tenant.migration.uuid');
