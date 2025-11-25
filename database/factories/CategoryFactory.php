<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Category::class;
    public function definition(): array
    {
        $directory = storage_path('app/public/categories');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        /*$imagePath = $this->faker->image(
            $directory, // where to save
            800,
            600,
            null, // category
            false // returns only filename, not full path
        );*/
        $random = Str::random(10);
        $name = $this->faker->unique()->words(2, true);
        return [
            'parent_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(2),
            'image' => "https://picsum.photos/seed/$random/200/200",
            'icon' => 'fas fa-' . $this->faker->randomElement(['mobile', 'laptop', 'headphones', 'camera', 'tv', 'shirt', 'shoes', 'book']),
            'order' => $this->faker->numberBetween(0, 50),
            'is_active' => $this->faker->boolean(90), // 90% chance active
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->sentence(20),
        ];
    }

    public function withParent()
    {
        return $this->state(fn () => [
            'parent_id' => Category::query()->inRandomOrder()->first()?->id,
        ]);
    }
}
