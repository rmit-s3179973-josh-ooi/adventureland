<?php

use Faker\Generator as Faker;
use App\Event;
use App\User;
use App\Category;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'event_title' =>$faker->sentence($nbWords = 6, $variableNbWords = true),
        'event_description' => $faker->text($maxNbChars = 200),
        'location' =>'',
        'start_datetime'=>$faker->dateTime($max = 'now',$timezone = null),
        'end_datetime' =>$faker->dateTime($max = 'now',$timezone = null),
        'category_id'=> function () {
        	return Category::inRandomOrder()->first()->id;
        }
    ];
});
