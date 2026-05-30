<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    protected $model = Candidature::class;

    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'entreprise'       => $this->faker->company(),
            'poste'            => $this->faker->jobTitle(),
            'url_offre'        => $this->faker->optional()->url(),
            'statut'           => $this->faker->randomElement(array_keys(Candidature::STATUTS)),
            'priorite'         => $this->faker->randomElement(array_keys(Candidature::PRIORITES)),
            'notes'            => $this->faker->optional()->paragraph(),
            'date_candidature' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        ];
    }
}
