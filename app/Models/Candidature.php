<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; 

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'entreprise',
        'poste',
        'url_offre',
        'statut',
        'priorite',
        'notes',
        'date_candidature',
        'fichier_path',
        'fichier_nom',
    ];

    protected $casts = [
        'date_candidature' => 'date',
    ];

    public const STATUTS = [
        'envoyee'      => 'Envoyée',
        'relancee'     => 'Relancée',
        'entretien'    => 'Entretien',
        'test_tech'    => 'Test technique',
        'offre'        => 'Offre reçue',
        'acceptee'     => 'Acceptée',
        'refusee'      => 'Refusée',
        'sans_suite'   => 'Sans suite',
    ];

    public const PRIORITES = [
        'haute'    => 'Haute',
        'normale'  => 'Normale',
        'basse'    => 'Basse',
    ];

    public const STATUS_CONFIG = [
        'envoyee'    => ['color' => 'bg-blue-100',   'text' => 'text-blue-800',    'hex' => '#3b82f6'], // Blue 500
        'relancee'   => ['color' => 'bg-yellow-100', 'text' => 'text-yellow-800',  'hex' => '#eab308'], // Yellow 500
        'entretien'  => ['color' => 'bg-purple-100', 'text' => 'text-purple-800',  'hex' => '#a855f7'], // Purple 500
        'test_tech'  => ['color' => 'bg-indigo-100', 'text' => 'text-indigo-800',  'hex' => '#6366f1'], // Indigo 500
        'offre'      => ['color' => 'bg-green-100',  'text' => 'text-green-800',   'hex' => '#22c55e'], // Green 500
        'acceptee'   => ['color' => 'bg-emerald-100','text' => 'text-emerald-800', 'hex' => '#10b981'], // Emerald 500
        'refusee'    => ['color' => 'bg-red-100',    'text' => 'text-red-800',     'hex' => '#ef4444'], // Red 500
        'sans_suite' => ['color' => 'bg-gray-100',   'text' => 'text-gray-600',    'hex' => '#94a3b8'], // Slate 400
    ];

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens(): HasMany
    {
        return $this->hasMany(Entretien::class)->orderBy('date_heure');
    }

    public function getStatutLibelleAttribute(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }

    public function getPrioriteLibelleAttribute(): string
    {
        return self::PRIORITES[$this->priorite] ?? $this->priorite;
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'envoyee'    => 'bg-blue-100 text-blue-800',
            'relancee'   => 'bg-yellow-100 text-yellow-800',
            'entretien'  => 'bg-purple-100 text-purple-800',
            'test_tech'  => 'bg-indigo-100 text-indigo-800',
            'offre'      => 'bg-green-100 text-green-800',
            'acceptee'   => 'bg-emerald-100 text-emerald-800',
            'refusee'    => 'bg-red-100 text-red-800',
            'sans_suite' => 'bg-gray-100 text-gray-600',
            default      => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPrioriteColorAttribute(): string
    {
        return match($this->priorite) {
            'haute'   => 'bg-red-100 text-red-700',
            'normale' => 'bg-gray-100 text-gray-600',
            'basse'   => 'bg-green-100 text-green-700',
            default   => 'bg-gray-100 text-gray-600',
        };
    }
}