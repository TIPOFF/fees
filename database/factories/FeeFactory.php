<?php

namespace Tipoff\Fees\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Fees\Models\Fee;
use Tipoff\Support\Support;

class FeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sentence = $this->faker->unique()->sentence;
        if ($this->faker->boolean) {
            $amount = $this->faker->numberBetween(100, 1000);
            $percent = null;
        } else {
            $amount = null;
            $percent = $this->faker->numberBetween(1, 50);
        }

        return [
            'name'          => $sentence,
            'slug'          => Str::slug($sentence),
            'title'         => $sentence,
            'amount'        => $amount,
            'percent'       => $percent,
            'applies_to'    => $this->faker->randomElement(['booking', 'participant', 'product', 'each']),
            'creator_id'    => Support::randomOrCreate(config('fees.model_class.user')),
        ];
    }
}
