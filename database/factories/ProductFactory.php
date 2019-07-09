<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'category' => array_rand(array_flip(['Electronic', 'Home & Lifestyle', 'Accessories'])),
        'name' => array_rand(array_flip(['Pen', 'Bookmark', 'Paper'])),
        'price' => rand(1, 100),
        'colour' => array_rand(array_flip(['Blue', 'Red', 'Green', 'Black'])),
        'size' => array_rand(array_flip(['S', 'M', 'L', 'XL'])),
        'product_code' => rand(1000, 9000),
        'product_details' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis esse aliquid alias sit blanditiis ea, neque quasi consequatur repellat ex iste deleniti vel illo quo quae expedita mollitia provident numquam!',
        'brand' => array_rand(array_flip(['Nike', 'Adidas', 'Puma', 'TopMan'])),
        'care' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis esse aliquid alias sit blanditiis ea, neque quasi consequatur repellat ex iste deleniti vel illo quo quae expedita mollitia provident numquam!',
        'vendor' => array_rand(array_flip(['trp', 'apw', 'tth', 's20', 'bou', 'bk'])),
        'stock' => rand(10, 50),
    ];
});
