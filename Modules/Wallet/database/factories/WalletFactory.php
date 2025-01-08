<?php

namespace Modules\Wallet\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Wallet\Models\Wallet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

