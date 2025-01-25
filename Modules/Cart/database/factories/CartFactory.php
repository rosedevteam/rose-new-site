<?php

namespace Modules\Cart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Cart\Models\Cart::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

