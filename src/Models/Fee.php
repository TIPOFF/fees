<?php

declare(strict_types=1);

namespace Tipoff\Fees\Models;

use Exception;
use Tipoff\Fees\Database\Factories\FeeFactory;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;

class Fee extends BaseModel
{
    use HasCreator;
    use HasPackageFactory;

    const APPLIES_TO_EACH = 'each';
    const APPLIES_TO_PRODUCT = 'product';
    const APPLIES_TO_BOOKING = 'booking';
    const APPLIES_TO_PARTICIPANT = 'participant';

    protected $casts = [];

    protected static function newFactory()
    {
        return FeeFactory::new();
    }

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

    public function locationBookingFees()
    {
        return $this->hasMany(app('location'), 'booking_fee_id');
    }

    public function locationProductFees()
    {
        return $this->hasMany(app('location'), 'product_fee_id');
    }

    public function bookings()
    {
        return $this->hasMany(app('booking'));
    }

    public function generateTotalFeesByCartItem($cartItem): int
    {
        $fee = 0;

        switch ($this->applies_to) {
            case self::APPLIES_TO_PRODUCT:
                break;
            case self::APPLIES_TO_BOOKING:
            case self::APPLIES_TO_EACH:
                if (! empty($this->percent)) {
                    $fee = $cartItem->amount * ($this->percent / 100);
                }
                if (! empty($this->amount)) {
                    $fee += $this->amount;
                }

                break;
            case self::APPLIES_TO_PARTICIPANT:
                $fee = $cartItem->participants * $this->amount;

                break;
        }

        return $fee;
    }
}
