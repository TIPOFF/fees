<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Fees\FeesServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\Fees\Tests\Support\Providers\NovaPackageServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AuthorizationServiceProvider::class,
            PermissionServiceProvider::class,
            FeesServiceProvider::class,
            LocationsServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
        ];
    }
}
