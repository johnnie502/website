<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'type' => 0,
        'status' => 1,
        'points' => 20,
        'notifications' => 0,
        'regip' => '127.0.0.1',
        'lastip' => '127.0.0.1',
    ];
});

$factory->define(App\Models\Topic::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});

$factory->define(App\Models\Node::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});

$factory->define(App\Models\File::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});

$factory->define(App\Models\Wiki::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});

$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    return [
        // 'name' => $faker->name,
    ];
});
