<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();
// 传参为生成最大时间不超过，因为创建时间需永远比更改时间要早
 //   $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
