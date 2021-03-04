<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Tests\TestCase;
use Tipoff\Support\Contracts\Checkout\CartInterface;
use Tipoff\Support\Contracts\Checkout\CartItemInterface;
use Tipoff\Support\Enums\AppliesTo;

class FeeModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Fee::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function percent_fee_amount()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->percent(10)->create();

        $amount = $fee->getFeeAmount(1230, 1);
        $this->assertEquals(123, $amount);
    }

    /** @test */
    public function fee_amount_per_participant()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PARTICIPANT(),
        ]);

        $amount = $fee->getFeeAmount(1230, 2);
        $this->assertEquals(200, $amount);
    }

    /** @test */
    public function fee_amount_per_product()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PRODUCT(),
        ]);

        $amount = $fee->getFeeAmount(1230, 2);
        $this->assertEquals(200, $amount);
    }

    /** @test */
    public function fee_amount_per_single_participant()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::SINGLE_PARTICIPANT(),
        ]);

        $amount = $fee->getFeeAmount(1230, 2);
        $this->assertEquals(100, $amount);
    }

    /** @test */
    public function cart_item_with_no_service()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PARTICIPANT(),
        ]);

        $cartItem = $fee->createCartItem(1230, 2);
        $this->assertNull($cartItem);
    }

    /** @test */
    public function cart_item_with_service()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PARTICIPANT(),
            'is_taxed' => false,
        ]);

        $cartItem = \Mockery::mock(CartItemInterface::class);
        $cartItem->shouldReceive('setParentItem')
            ->with(null)
            ->once()
            ->andReturnSelf();

        $service = \Mockery::mock(CartInterface::class);
        $service->shouldReceive('createItem')
            ->withArgs(function ($sellable, $itemId, $amount) use ($fee) {
                return $sellable->id === $fee->id &&
                    $itemId === $fee->slug &&
                    $amount === 200;
            })
            ->once()
            ->andReturn($cartItem);
        $this->app->instance(CartInterface::class, $service);

        $cartItem = $fee->createCartItem(1230, 2);
        $this->assertNotNull($cartItem);
    }

    /** @test */
    public function cart_item_with_link()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PARTICIPANT(),
            'is_taxed' => false,
        ]);

        $linkedItem = \Mockery::mock(CartItemInterface::class);

        $cartItem = \Mockery::mock(CartItemInterface::class);
        $cartItem->shouldReceive('setParentItem')
            ->with($linkedItem)
            ->once()
            ->andReturnSelf();

        $service = \Mockery::mock(CartInterface::class);
        $service->shouldReceive('createItem')
            ->withArgs(function ($sellable, $itemId, $amount) use ($fee) {
                return $sellable->id === $fee->id &&
                    $itemId === $fee->slug &&
                    $amount === 200;
            })
            ->once()
            ->andReturn($cartItem);
        $this->app->instance(CartInterface::class, $service);

        $cartItem = $fee->createCartItem(1230, 2, $linkedItem);
        $this->assertNotNull($cartItem);
    }

    /** @test */
    public function cart_item_with_tax()
    {
        /** @var Fee $fee */
        $fee = Fee::factory()->amount(100)->create([
            'applies_to' => AppliesTo::PARTICIPANT(),
            'is_taxed' => true,
        ]);

        $cartItem = \Mockery::mock(CartItemInterface::class);
        $cartItem->shouldReceive('setParentItem')
            ->with(null)
            ->once()
            ->andReturnSelf();
        $cartItem->shouldReceive('setTaxCode')
            ->with('fee')
            ->once()
            ->andReturnSelf();

        $service = \Mockery::mock(CartInterface::class);
        $service->shouldReceive('createItem')
            ->withArgs(function ($sellable, $itemId, $amount) use ($fee) {
                return $sellable->id === $fee->id &&
                    $itemId === $fee->slug &&
                    $amount === 200;
            })
            ->once()
            ->andReturn($cartItem);
        $this->app->instance(CartInterface::class, $service);

        $cartItem = $fee->createCartItem(1230, 2);
        $this->assertNotNull($cartItem);
    }
}
