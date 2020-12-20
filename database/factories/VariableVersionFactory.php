<?php

namespace Database\Factories;

use App\Models\VariableVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariableVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VariableVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->word,
        ];
    }
}
