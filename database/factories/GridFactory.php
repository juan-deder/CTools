<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grid;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Collection;

$factory->define(Grid::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->afterCreatingState(\App\Grid::class, 'with_committers', function ($grid, $faker) {
    $users = ($existing = User::all())->isNotEmpty() ? $existing : factory(\App\User::class, 3)->create();

    $roles = $users->pluck('id')->combine(Collection::times(3, fn () =>
        ['roles' => ['owner', implode(',', $faker->randomElements(['approver', 'editor', 'observer'], rand(1, 3), false))][rand(0, 1)]]
    ));

    $grid->committers()->attach($roles);
});
