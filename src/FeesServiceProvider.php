<?php

declare(strict_types=1);

namespace Tipoff\Fees;

use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Policies\FeePolicy;
use Tipoff\Fees\View\Components;
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
                \Tipoff\Fees\Nova\LocationFee::class,
            ])
            ->hasBladeComponents([
                'fee-cart-item' => Components\Cart\FeeComponent::class,
                'fee-order-item' => Components\Order\FeeComponent::class,
            ])
            ->name('fees')
            ->hasViews()
            ->hasConfigFile();
    }
}
