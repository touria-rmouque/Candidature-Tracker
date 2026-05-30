<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entretien extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_id',
        'type',
        'date_heure',
        'notes_preparation',
        'resultat',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public const TYPES = [
        'phone'       => 'Téléphonique',
        'visio'       => 'Visioconférence',
        'presentiel'  => 'Présentiel',
        'technique'   => 'Test technique',
        'rh'          => 'RH / Culture fit',
    ];

    public const RESULTATS = [
        'en_attente' => 'En attente',
        'positif'    => 'Positif',
        'negatif'    => 'Négatif',
        'annule'     => 'Annulé',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    public function getTypeLibelleAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getResultatLibelleAttribute(): string
    {
        return self::RESULTATS[$this->resultat] ?? ($this->resultat ?? 'En attente');
    }

    public function getResultatColorAttribute(): string
    {
        return match($this->resultat) {
            'positif'    => 'bg-green-100 text-green-700',
            'negatif'    => 'bg-red-100 text-red-700',
            'annule'     => 'bg-gray-100 text-gray-500',
            default      => 'bg-yellow-100 text-yellow-700',
        };
    }
}
