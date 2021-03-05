<?php

declare(strict_types=1);

namespace Tipoff\Fees\View\Components\Order;

use Illuminate\View\Component;
use Illuminate\View\View;
use Tipoff\Fees\Models\Fee;
use Tipoff\Support\Contracts\Checkout\CartItemInterface;
use Tipoff\Support\Contracts\Checkout\OrderItemInterface;

class FeeComponent extends Component
{
    public OrderItemInterface $orderItem;
    public Fee $sellable;

    public function __construct(OrderItemInterface $orderItem, Fee $sellable)
    {
        $this->orderItem = $orderItem;
        $this->sellable = $sellable;
    }

    public function render()
    {
        /** @var View $view */
        $view = view('fees::components.order.fee');

        return $view;
    }
}
