<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition()
    {
        return [
            'author' => $this->faker->name,
            'title' => $this->faker->sentence,
        ];
    }
}
