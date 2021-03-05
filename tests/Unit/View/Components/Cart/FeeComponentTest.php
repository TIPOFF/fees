<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\View\Components\Cart;

use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Tests\TestCase;
use Tipoff\Support\Contracts\Checkout\CartItemInterface;

class FeeComponentTest extends TestCase
{
    /** @test */
    public function single_item()
    {
        /** @var Fee $sellable */
        $sellable = Fee::factory()->amount(1234)->create();
        $cartItem = \Mockery::mock(CartItemInterface::class);

        $view = $this->blade(
            '<x-tipoff-fee-cart-item :cart-item="$cartItem" :sellable="$sellable" />',
            [
                'cartItem' => $cartItem,
                'sellable' => $sellable,
            ]
        );

        // Invisible!
        $this->assertEquals('', (string) $view);
    }
}
