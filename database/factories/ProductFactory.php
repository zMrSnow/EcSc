<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
        "description" => $faker->paragraph,
        "weight" => $faker->numberBetween(50, 2000),
        "price" => $faker->numberBetween(1, 90)
    ];
});
