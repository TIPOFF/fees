<?php

declare(strict_types=1);

namespace Tipoff\Fees\Models;

use Tipoff\Locations\Models\Location;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class LocationFee extends BaseModel
{
    use HasCreator;
    use HasUpdater;
    use HasPackageFactory;

    public function location()
    {
        return $this->belongsTo(app('location'));
    }

    public function bookingFee()
    {
        return $this->belongsTo(app('fee'), 'booking_fee_id');
    }

    public function productFee()
    {
        return $this->belongsTo(app('fee'), 'product_fee_id');
    }
}
