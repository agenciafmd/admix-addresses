<?php

namespace Database\Factories;

use Agenciafmd\Addresses\Models\Address;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'collection' => 'default',
            'full_street' => $this->faker->address,
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional(0.3)->secondaryAddress,
            'neighborhood' => $this->faker->secondaryAddress,
            'state' => $state = $this->faker->state,
            'state_initials' => $this->faker->stateAbbr,
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
