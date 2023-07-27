<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Test Data Provider',
            'url' => 'https://dog.ceo/api/breeds/image/random'
        ];
    }
}
