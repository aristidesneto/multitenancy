<?php

use Illuminate\Support\Facades\Route;
use Aristides\Multitenancy\Http\Controllers\TenantController;

Route::middleware(['web', 'auth', 'check.domain.main'])->prefix('admin')->group(function () {
    Route::get('/', [TenantController::class, 'index'])->name('tenant.index');
    Route::post('store', [TenantController::class, 'store'])->name('tenant.store');
    Route::post('migration', [TenantController::class, 'migration'])->name('tenant.migration');
    Route::get('migration/{uuid}', [TenantController::class, 'migrationByUuid'])->name('tenant.migration.uuid');
});
