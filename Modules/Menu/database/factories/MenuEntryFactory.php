<?php

namespace Modules\Menu\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Menu\Models\MenuEntry::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

