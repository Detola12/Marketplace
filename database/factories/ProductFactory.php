<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;
    public function definition(): array
    {
        $name = $this->faker->sentence(4);
        $price = $this->faker->randomFloat(2, 10, 1000);
        $comparePrice = $this->faker->optional(0.7)->randomFloat(2, $price + 10, $price + 200);

        return [
            'vendor_id' => Vendor::query()->inRandomOrder()->first()?->id,
            'category_id' => Category::query()->whereNull('parent_id')->inRandomOrder()->first()?->id
                ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'description' => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->paragraph(),
            'price' => $price,
            'compare_price' => $comparePrice,
            'cost_price' => $this->faker->randomFloat(2, 5, $price * 0.8),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'barcode' => $this->faker->optional()->ean13(),
            'stock_quantity' => $this->faker->numberBetween(0, 200),
            'low_stock_threshold' => $this->faker->numberBetween(3, 15),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'length' => $this->faker->randomFloat(2, 5, 100),
            'width' => $this->faker->randomFloat(2, 5, 100),
            'height' => $this->faker->randomFloat(2, 5, 100),
            'status' => $this->faker->randomElement(['active', 'active', 'inactive', 'out_of_stock']),
            'is_featured' => $this->faker->boolean(15),
            'is_taxable' => $this->faker->boolean(95),
            'tax_rate' => $this->faker->randomElement([0.00, 5.00, 10.00, 20.00]),
            'meta_title' => $name,
            'meta_description' => $this->faker->sentence(15),
            'meta_keywords' => implode(', ', $this->faker->words(8)),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function is_featured()
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }
}
