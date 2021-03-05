<?php

declare(strict_types=1);

namespace Tipoff\Fees\View\Components\Cart;

use Illuminate\View\Component;
use Illuminate\View\View;
use Tipoff\Fees\Models\Fee;
use Tipoff\Support\Contracts\Checkout\CartItemInterface;

class FeeComponent extends Component
{
    public CartItemInterface $cartItem;
    public Fee $sellable;

    public function __construct(CartItemInterface $cartItem, Fee $sellable)
    {
        $this->cartItem = $cartItem;
        $this->sellable = $sellable;
    }

    public function render()
    {
        /** @var View $view */
        $view = view('fees::components.cart.fee');

        return $view;
    }
}
