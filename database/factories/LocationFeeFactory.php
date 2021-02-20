<?php

declare(strict_types=1);

namespace Tipoff\Fees\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Fees\Models\Fee;
use Tipoff\Fees\Models\LocationFee;
use Tipoff\Locations\Models\Location;

class LocationFeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LocationFee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'location_id'    => randomOrCreate(Location::class),
            'booking_fee_id' => randomOrCreate(Fee::class),
            'product_fee_id' => randomOrCreate(Fee::class),
            'creator_id'     => randomOrCreate(app('user')),
            'updater_id'     => randomOrCreate(app('user'))
        ];
    }
}
