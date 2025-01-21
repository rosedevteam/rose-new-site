<?php

namespace Modules\Referral\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReferralFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Referral\Models\Referral::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

