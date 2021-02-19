<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Fees\Models\LocationFee;
use Tipoff\Fees\Tests\TestCase;

class LocationFeeModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = LocationFee::factory()->create();
        $this->assertNotNull($model);
    }
}
