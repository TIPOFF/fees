<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\View\Components\Order;

use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Tests\TestCase;
use Tipoff\Support\Contracts\Checkout\OrderItemInterface;

class FeeComponentTest extends TestCase
{
    /** @test */
    public function single_item()
    {
        /** @var Fee $sellable */
        $sellable = Fee::factory()->amount(1234)->create();
        $orderItem = \Mockery::mock(OrderItemInterface::class);

        $view = $this->blade(
            '<x-tipoff-fee-order-item :order-item="$orderItem" :sellable="$sellable" />',
            [
                'orderItem' => $orderItem,
                'sellable' => $sellable,
            ]
        );

        // Invisible!
        $this->assertEquals('', (string) $view);
    }
}
