<?php

namespace Modules\Discount\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Discount\Models\Discount::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

