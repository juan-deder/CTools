<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence,
        'content_id' => factory(\App\Content::class),
        'user_id' => factory(\App\User::class),
    ];
});
