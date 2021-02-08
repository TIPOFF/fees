<?php

namespace Tipoff\Fees\Models;

use Exception;
use Tipoff\Fees\Database\Factories\FeeFactory;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Fee extends BaseModel
{
    use HasPackageFactory;

    const APPLIES_TO_EACH = 'each';
    const APPLIES_TO_PRODUCT = 'product';
    const APPLIES_TO_BOOKING = 'booking';
    const APPLIES_TO_PARTICIPANT = 'participant';

    protected $guarded = ['id'];
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

        static::creating(function ($fee) {
            if (auth()->check()) {
                $fee->creator_id = auth()->id();
            }
        });
        static::saving(function ($fee) {
            if (empty($fee->amount) && empty($fee->percent)) {
                throw new Exception('A fee must have either an amount or percent.');
            }
            if (! empty($fee->amount) && ! empty($fee->percent)) {
                throw new Exception('A fee cannot have both an amount & percent.');
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(config('tipoff.model_class.user'), 'creator_id');
    }

    public function locationBookingFees()
    {
        return $this->hasMany(config('tipoff.model_class.location'), 'booking_fee_id');
    }

    public function locationProductFees()
    {
        return $this->hasMany(config('tipoff.model_class.location'), 'product_fee_id');
    }

    public function bookings()
    {
        return $this->hasMany(config('tipoff.model_class.booking'));
    }
}
