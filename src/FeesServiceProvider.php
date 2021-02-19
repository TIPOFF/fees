<?php

declare(strict_types=1);

namespace Tipoff\Fees;

use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Policies\FeePolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FeesServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Fee::class => FeePolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Fees\Nova\Fee::class,
            ])
            ->name('fees')
            ->hasConfigFile();
    }
}
