<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Tests\TestCase;

class CustomerModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Fee::factory()->create();
        $this->assertNotNull($model);
    }
}
