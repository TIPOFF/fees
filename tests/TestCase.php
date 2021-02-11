<?php

namespace Tipoff\Fees\Tests;

use Tipoff\Fees\FeesServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            FeesServiceProvider::class,
        ];
    }
}
