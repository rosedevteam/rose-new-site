<?php

namespace Modules\Channel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Channel\Models\Channel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

