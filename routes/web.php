<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['web', 'auth', 'can:see-app-zentrale'])->group(function (): void {
    Volt::route('apps/zentrale', 'apps.zentrale.index')->name('apps.zentrale.index');
    Volt::route('apps/zentrale/info', 'apps.zentrale.info')->name('apps.zentrale.info');
});

Route::middleware(['web', 'auth', 'can:manage-app-zentrale'])->group(function (): void {
    Volt::route('apps/zentrale/admin', 'apps.zentrale.admin.index')->name('apps.zentrale.admin.index');
});
