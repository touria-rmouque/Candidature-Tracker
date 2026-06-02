<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name'  => 'Touria Rmouque',
            'email' => 'touria@gmail.com',
        ]);

        $candidatures = Candidature::factory(10)->create(['user_id' => $user->id]);


        $candidatures->take(4)->each(function (Candidature $c) {
            Entretien::factory(rand(1, 3))->create(['candidature_id' => $c->id]);
        });

        Candidature::factory(3)->create(['user_id' => $user->id])->each(fn ($c) => $c->delete());
    }
}
