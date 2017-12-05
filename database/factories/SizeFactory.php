<?php

use App\Product;
use App\Size;
use Faker\Generator as Faker;

$factory->define(Size::class, function (Faker $faker) {
    return [
        "product_id" => Product::all()->random(),
        "name" => $faker->word,
        "quantities" => $faker->numberBetween(0,10)
    ];
});
