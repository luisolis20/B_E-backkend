<?php

namespace Database\Factories;

use App\Models\Oferta_Empleo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postulacion>
 */
class PostulacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => function () {
                return User::factory()->create()->id;
            },
            'oferta_id' => function () {
                return Oferta_Empleo::factory()->create()->id;
            },
        ];
    }
}
