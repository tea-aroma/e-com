<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * @var int
     */
    protected static int $sortOrder = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::$sortOrder += 10;

        $name = $this->faker->unique()->company;

        return [
            'name' => $name,
            'code' => Str::slug($name),
            'sort_order' => self::$sortOrder,
        ];
    }
}
