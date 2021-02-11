<?php

namespace Tipoff\Fees\Tests;

use Tipoff\Fees\FeesServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FeesServiceProvider::class,
        ];
    }
}
