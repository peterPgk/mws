<?php

/* @var $factory Factory */

use App\Answer;
use App\Question;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => function ($faker) {
            return factory(Question::class)->create()->id;
        },
        'text' => $faker->text
    ];
});
