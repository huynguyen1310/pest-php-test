<?php

namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fromDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        return [
            'product_id' => fn () => Product::factory()->create()->id,
            'price' => $this->faker->randomFloat(2, 10, 200),
            'from_date' => $fromDate,
            'to_date' => Carbon::parse($fromDate)->addDays(rand(1, 100)),
        ];
    }
}
