<?php

use App\Models\Category;
use function Pest\Laravel\getJson;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should return a category', function () {
    $category = Category::factory([
        'name'        => 'Books',
        'description' => 'Category for books'
    ])->create();

    $response = getJson(route('categories.show', ['category' => $category->id]))->json('data');
    expect($response)->toMatchArray([
        'id'          => $category->id,
        'name'        => 'Books',
        'description' => 'Category for books',
    ]);
});
