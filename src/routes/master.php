<?php

use Aristides\Multitenancy\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TenantController::class, 'index'])->name('tenants.index');
Route::get('/create', [TenantController::class, 'create'])->name('tenants.create');

Route::post('store', [TenantController::class, 'store'])->name('tenants.store');
Route::post('migration', [TenantController::class, 'migration'])->name('tenants.migration');
Route::get('migration/{uuid}/{action?}', [TenantController::class, 'migrationByUuid'])->name('tenants.migration.uuid');

Route::get('active/production/{uuid}', [TenantController::class, 'production'])->name('tenants.production');

