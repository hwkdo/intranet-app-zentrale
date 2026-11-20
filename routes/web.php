<?php

declare(strict_types=1);

use Hwkdo\IntranetAppZentrale\Livewire\Apps\Zentrale\Settings\Notifications;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['web', 'auth', 'can:see-app-zentrale'])->group(function (): void {
    Volt::route('apps/zentrale', 'apps.zentrale.index')->name('apps.zentrale.index');
    Volt::route('apps/zentrale/info', 'apps.zentrale.info')->name('apps.zentrale.info');
    Route::get('apps/zentrale/settings/notifications', Notifications::class)
        ->name('apps.zentrale.settings.notifications');
});

Route::middleware(['web', 'auth', 'can:manage-app-zentrale'])->group(function (): void {
    Volt::route('apps/zentrale/admin', 'apps.zentrale.admin.index')->name('apps.zentrale.admin.index');
});
