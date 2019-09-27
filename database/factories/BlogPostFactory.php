<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\BlogPost;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\BlogPost::class, function (Faker $faker) {
    $title = $faker->sentence(rand(3, 8), true);
    $text = $faker->realText(rand(1000, 4000));
    $isPublished = rand(1, 5) > 1;

    $createAt = $faker->dateTimeBetween('-3 months', '1 days');
    //$createAt = '2019/09/17';

    $data = [
        'category_id' => rand(1, 11),
        'user_id' => (rand(1, 5) == 5) ? 1 : 2,
        'title' => $title,
        'slug' => Str::slug($title),
        'excerpt' => $faker->text(rand(40, 100)),
        'content_raw' => $text,
        'content_html' => $text,
        'is_published' => $isPublished,
        'published_at' => $isPublished ? $faker->dateTimeBetween('-2 moths', '1 days') : null,
        'created_at' => $createAt,
        'updated_at' => $createAt,
    ];
    return $data;
});