<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntretienFactory extends Factory
{
    protected $model = Entretien::class;

    public function definition(): array
    {
        return [
            'candidature_id'    => Candidature::factory(),
            'type'              => $this->faker->randomElement(array_keys(Entretien::TYPES)),
            'date_heure'        => $this->faker->dateTimeBetween('now', '+1 month'),
            'notes_preparation' => $this->faker->optional()->paragraph(),
            'resultat'          => $this->faker->optional()->randomElement(array_keys(Entretien::RESULTATS)),
        ];
    }
}
