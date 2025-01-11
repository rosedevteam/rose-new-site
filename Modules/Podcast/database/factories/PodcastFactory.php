<?php

namespace Modules\Podcast\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Podcast\Models\Podcast::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

