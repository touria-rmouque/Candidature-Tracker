<?php

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// AUTHENTIFICATION
test('un visiteur est redirigé vers login', function () {
    $this->get(route('candidatures.index'))
        ->assertRedirect(route('login'));
});

test('un utilisateur connecté accède à la liste', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('candidatures.index'))
        ->assertOk();
});

// CRÉATION DE CANDIDATURE

test('un utilisateur peut créer une candidature avec des données valides', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise'       => 'Google',
            'poste'            => 'Développeur Laravel',
            'url_offre'        => 'https://google.com/jobs/1',
            'statut'           => 'envoyee',
            'priorite'         => 'haute',
            'notes'            => 'Très bonne opportunité',
            'date_candidature' => '2024-06-15',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('candidatures', [
        'user_id'    => $user->id,
        'entreprise' => 'Google',
        'poste'      => 'Développeur Laravel',
    ]);
});

test('la création échoue avec des données invalides', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise'       => '', 
            'poste'            => '', 
            'statut'           => 'statut_invalide',
            'priorite'         => 'normale',
            'date_candidature' => 'pas-une-date',
        ])
        ->assertSessionHasErrors(['entreprise', 'poste', 'statut', 'date_candidature']);
});

test('la création échoue si url_offre n\'est pas une URL valide', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise'       => 'Apple',
            'poste'            => 'Designer',
            'url_offre'        => 'pas-une-url',
            'statut'           => 'envoyee',
            'priorite'         => 'normale',
            'date_candidature' => '2024-06-01',
        ])
        ->assertSessionHasErrors(['url_offre']);
});

// POLICY — ACCÈS BLOQUÉ PAR LA POLICY

test('un utilisateur ne peut pas voir la candidature d\'un autre', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $candidature = Candidature::factory()->create(['user_id' => $userA->id]);

    $this->actingAs($userB)
        ->get(route('candidatures.show', $candidature))
        ->assertForbidden();
});

test('un utilisateur ne peut pas modifier la candidature d\'un autre', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $candidature = Candidature::factory()->create(['user_id' => $userA->id]);

    $this->actingAs($userB)
        ->put(route('candidatures.update', $candidature), [
            'entreprise'       => 'Pirate',
            'poste'            => 'Hacker',
            'statut'           => 'envoyee',
            'priorite'         => 'normale',
            'date_candidature' => '2024-01-01',
        ])
        ->assertForbidden();
});

test('un utilisateur ne peut pas archiver la candidature d\'un autre', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $candidature = Candidature::factory()->create(['user_id' => $userA->id]);

    $this->actingAs($userB)
        ->delete(route('candidatures.destroy', $candidature))
        ->assertForbidden();
});

// ARCHIVAGE ET RESTAURATION

test('archiver une candidature la soft-delete', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->delete(route('candidatures.destroy', $candidature))
        ->assertRedirect(route('candidatures.index'));

    $this->assertSoftDeleted('candidatures', ['id' => $candidature->id]);
});

test('une candidature archivée n\'apparaît pas dans la liste active', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $candidature->delete();

    $this->actingAs($user)
        ->get(route('candidatures.index'))
        ->assertDontSee($candidature->entreprise);
});

test('restaurer une candidature la remet dans la liste active', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $candidature->delete();

    $this->actingAs($user)
        ->patch(route('candidatures.restore', $candidature->id))
        ->assertRedirect(route('candidatures.archives'));

    $this->assertDatabaseHas('candidatures', [
        'id'         => $candidature->id,
        'deleted_at' => null,
    ]);
});

test('un utilisateur ne peut pas restaurer la candidature d\'un autre', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $candidature = Candidature::factory()->create(['user_id' => $userA->id]);
    $candidature->delete();

    $this->actingAs($userB)
        ->patch(route('candidatures.restore', $candidature->id))
        ->assertForbidden();
});

// FILTRES 

test('le filtre par statut fonctionne correctement', function () {
    $user = User::factory()->create();
    Candidature::factory()->create(['user_id' => $user->id, 'statut' => 'envoyee', 'entreprise' => 'Alpha']);
    Candidature::factory()->create(['user_id' => $user->id, 'statut' => 'entretien', 'entreprise' => 'Beta']);

    $response = $this->actingAs($user)
        ->get(route('candidatures.index', ['statut' => 'envoyee']));

    $response->assertSee('Alpha')
             ->assertDontSee('Beta');
});

// ENTRETIENS

test('un utilisateur peut ajouter un entretien à sa candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type'               => 'visio',
            'date_heure'         => '2024-07-01 14:00:00',
            'notes_preparation'  => 'Préparer portfolio',
            'resultat'           => 'en_attente',
        ])
        ->assertRedirect(route('candidatures.show', $candidature));

    $this->assertDatabaseHas('entretiens', [
        'candidature_id' => $candidature->id,
        'type'           => 'visio',
    ]);
});

test('un utilisateur peut supprimer un entretien de sa candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $entretien = Entretien::factory()->create(['candidature_id' => $candidature->id]);

    $this->actingAs($user)
        ->delete(route('entretiens.destroy', [$candidature, $entretien]))
        ->assertRedirect(route('candidatures.show', $candidature));

    $this->assertDatabaseMissing('entretiens', ['id' => $entretien->id]);
});

// BONUS — FILE STORAGE

test('un utilisateur peut attacher un fichier à sa candidature', function () {
    Storage::fake('private');
    $user = User::factory()->create();

    $fichier = UploadedFile::fake()->create('cv.pdf', 500, 'application/pdf');

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise'       => 'Amazon',
            'poste'            => 'Ingénieur',
            'statut'           => 'envoyee',
            'priorite'         => 'normale',
            'date_candidature' => '2024-06-01',
            'fichier'          => $fichier,
        ])
        ->assertRedirect();

    $candidature = Candidature::where('user_id', $user->id)->first();
    expect($candidature->fichier_nom)->toBe('cv.pdf');
    Storage::disk('private')->assertExists($candidature->fichier_path);
});
