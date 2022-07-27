<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('should return all products for a category', function () {
    $category = Category::factory()
        ->has(Product::factory()->count(3))
        ->create();

    Category::factory()
        ->has(Product::factory()->count(10))
        ->create();

    $products = getJson(route('category/products.index', ['category' => $category->id]))->json('data');
    expect($products)->toHaveCount(3);
});
