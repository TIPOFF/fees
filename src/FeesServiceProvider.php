<?php

namespace Tipoff\Fees;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Fees\Commands\FeesCommand;
use Illuminate\Support\Str;


class FeesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('fees')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('2020_02_16_120000_create_fees_table')
            ->hasCommand(FeesCommand::class);
    }

    public function boot()
    {
        parent::boot();
        foreach ($this->package->migrationFileNames as $migrationFileName) {
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    $this->package->basePath("/../database/migrations/{$migrationFileName}.php.stub") => database_path('migrations/' . Str::finish($migrationFileName, '.php')),
                ], "{$this->package->name}-migrations");
            }
        }
    }
}
