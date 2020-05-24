<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        'planned_for' => $faker->dateTime('1 month'),
        'channels' => implode(',', $faker->randomElements(['facebook', 'instagram', 'twitter', 'tiktok', 'whatsapp', 'snapchat'], rand(1, 6), false)),
        'title' => $faker->sentence,
        'description' => $faker->text,
        'tags' => $faker->sentence,
        'location' => $faker->streetName,
        'grid_id' => factory(\App\Grid::class),
    ];
});
