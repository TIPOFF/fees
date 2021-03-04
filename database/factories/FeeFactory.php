<?php

declare(strict_types=1);

namespace Tipoff\Fees\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Fees\Models\Fee;

class FeeFactory extends Factory
{
    protected $model = Fee::class;

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
            'creator_id'    => randomOrCreate(app('user')),
        ];
    }

    public function amount(?int $amount): self
    {
        return $this
            ->state(function (array $attributes) use ($amount) {
                return [
                    'amount'   => $amount ?? $this->faker->numberBetween(100, 1000),
                    'percent'  => null,
                ];
            });
    }

    public function percent(?float $percent): self
    {
        return $this
            ->state(function (array $attributes) use ($percent) {
                return [
                    'amount'  => null,
                    'percent' => $percent ?? $this->faker->numberBetween(1, 50),
                ];
            });
    }
}
