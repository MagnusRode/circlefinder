<?php

use Faker\Generator as Faker;

$factory->define(\App\Language::class, function (Faker $faker) {
    $language_code = $faker->languageCode;
    
    $list = \App\Language::getListOfLanguages();

    return [
        'title' => $list[$language_code],
        'code' => $language_code
    ];
});
