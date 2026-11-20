<?php

namespace Hwkdo\IntranetAppZentrale;

use Livewire\Livewire;
use Livewire\Volt\Volt;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class IntranetAppZentraleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('intranet-app-zentrale')
            ->hasConfigFile()
            ->hasViews()
            ->discoversMigrations();
    }

    public function bootingPackage(): void
    {
        Livewire::addNamespace(
            namespace: 'intranet-app-zentrale',
            classNamespace: 'Hwkdo\\IntranetAppZentrale\\Livewire',
            classPath: __DIR__.'/Livewire',
            classViewPath: __DIR__.'/../resources/views/livewire',
            viewPath: __DIR__.'/../resources/views/livewire',
        );
    }

    public function boot(): void
    {
        parent::boot();
        // Gate::policy(Raum::class, RaumPolicy::class);
        $this->app->booted(function () {
            Volt::mount(__DIR__.'/../resources/views/livewire');
        });
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    }
}
