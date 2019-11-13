<?php

use Faker\Generator;
use Agenciafmd\Addresses\Address;

$factory->define(Address::class, function (Generator $faker) {
    return [
        'collection' => 'default',
        'full_street' => $address = $faker->address,
        'street' => $faker->streetAddress,
        'number' => $faker->buildingNumber,
        'complement' => $faker->boolean(30) ? $faker->secondaryAddress : null,
        'neighborhood' => $faker->secondaryAddress,
        'state' => $state = $faker->state,
        'state_initials' => $faker->stateAbbr,
        'city' => $faker->city,
        'zipcode' => $faker->postcode,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});

