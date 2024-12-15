<?php

namespace Modules\JobOffer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\JobApplication\Models\JobApplication::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

