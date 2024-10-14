<?php

namespace Database\Factories;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oferta_Empleo>
 */
class Oferta_EmpleoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->jobTitle,
            'descripcion' => $this->faker->text,
            'requisistos' => $this->faker->text,
            'empresa_id' => function () {
                return Empresa::factory()->create()->id;
            },
        ];
    }
}
