<?php

$products = [
    ['id' => 1, 'name' => 'iPhone', 'price' => 1000],
    ['id' => 2, 'name' => 'Samsung', 'price' => 800],
    ['id' => 3, 'name' => 'Xiaomi', 'price' => 500]
];

$names = array_map(
    fn($product) => $product['name'],
    $products
);