<?php

namespace Modules\DailyReport\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DailyReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\DailyReport\Models\DailyReport::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

