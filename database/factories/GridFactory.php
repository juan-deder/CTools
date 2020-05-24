<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grid;
use Faker\Generator as Faker;

$factory->define(Grid::class, function (Faker $faker) {
    return [
        'org_name' => $faker->company,
    ];
});

$factory->afterCreatingState(\App\Grid::class, 'with_committers', function ($grid, $faker) {
    $users = factory(\App\User::class, 3)->create();

    $roles = $users->pluck('id')->combine(\Illuminate\Support\Collection::times(3, function () use ($faker) {
        return ['roles' => implode(',', $faker->randomElements(['creator', 'approver'], rand(1, 2), false))];
    }));

    $grid->commiters()->attach($roles);
});
