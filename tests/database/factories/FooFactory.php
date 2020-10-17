<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use VoyagerSelectRelation\Tests\Traits\Foo;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Foo::class, function (Faker $faker) {
    return [
        'test_parent_id' => 0,
    ];
});
