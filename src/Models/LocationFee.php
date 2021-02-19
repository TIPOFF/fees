<?php

declare(strict_types=1);

namespace Tipoff\Fees\Models;

use Tipoff\Fees\Database\Factories\FeeFactory;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class LocationFee extends BaseModel
{
    use HasCreator;
    use HasUpdater;
    use HasPackageFactory;

    protected static function newFactory()
    {
        return FeeFactory::new();
    }
}
