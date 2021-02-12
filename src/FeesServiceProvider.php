<?php

namespace Tipoff\Fees;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Policies\FeePolicy;

class FeesServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->hasModelInterfaces([
                FeeInterface::class => Fee::class,
            ])
            ->hasPolicies([
                Fee::class => FeePolicy::class,
            ])
            ->name('fees')
            ->hasConfigFile()
            ->hasViews();
    }

    public function registeringPackage()
    {
        Gate::policy(Fee::class, FeePolicy::class);
    }
}
