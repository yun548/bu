<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'siret' => $this->faker->numerify('##############'),
            'customs_code' => $this->faker->bothify('####??'),
            'document_path' => 'documents/' . $this->faker->uuid . '.pdf',
        ];
    }
}