<?php

declare(strict_types=1);

namespace Tipoff\Fees\Models;

use Exception;
use Tipoff\Support\Contracts\Checkout\CartInterface;
use Tipoff\Support\Contracts\Checkout\CartItemInterface;
use Tipoff\Support\Contracts\Sellable\Fee as FeeInterface;
use Tipoff\Support\Enums\AppliesTo;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;

/**
 * @property int id
 * @property string slug
 * @property string name
 * @property string title
 * @property int amount
 * @property float percent
 * @property AppliesTo applies_to
 * @property bool is_taxed
 * @property int creator_id
 */
class Fee extends BaseModel implements FeeInterface
{
    use HasCreator;
    use HasPackageFactory;

    const UPDATED_AT = null;

    protected $casts = [
        'percent' => 'float',
        'amount' => 'integer',
        'is_taxed' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($fee) {
            if (empty($fee->amount) && empty($fee->percent)) {
                throw new Exception('A fee must have either an amount or percent.');
            }
            if (! empty($fee->amount) && ! empty($fee->percent)) {
                throw new Exception('A fee cannot have both an amount & percent.');
            }
        });
    }

    //region RELATIONS

    public function locationBookingFees()
    {
        return $this->hasMany(LocationFee::class, 'booking_fee_id');
    }

    public function locationProductFees()
    {
        return $this->hasMany(LocationFee::class, 'product_fee_id');
    }

    public function bookings()
    {
        return $this->hasMany(app('booking'));
    }

    //endregion

    //region INTERFACE

    public function getDescription(): string
    {
        return $this->name;
    }

    public function getViewComponent($context = null)
    {
        return implode('-', ['tipoff', 'fee', $context]);
    }

    //endregion

    public function createCartItem(int $baseAmount, int $participantsOrQuantity = 1, ?CartItemInterface $linkedCartItem = null): ?CartItemInterface
    {
        /** @var CartInterface $service */
        $service = findService(CartInterface::class);
        if ($service) {
            $item = $service::createItem($this, $this->slug, $this->getFeeAmount($baseAmount, $participantsOrQuantity))
                ->setParentItem($linkedCartItem);

            if ($this->is_taxed) {
                // TODO - what code to set here?  Move TaxCode to support possibly?
                $item->setTaxCode('fee');
            }

            return $item;
        }

        return null;
    }

    public function getFeeAmount(int $baseAmount, int $participantsOrQuantity = 1): int
    {
        if ($this->percent) {
            return (int) (($baseAmount * $this->percent) / 100);
        }

        if ($this->applies_to === AppliesTo::PARTICIPANT() ||
            $this->applies_to === AppliesTo::PRODUCT()) {
            return $participantsOrQuantity * $this->amount;
        }

        return $this->amount;
    }
}
