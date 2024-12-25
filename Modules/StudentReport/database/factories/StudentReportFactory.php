<?php

namespace Modules\StudentReport\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\StudentReport\Models\StudentReport::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

