<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntretienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'               => ['required', 'string', 'in:phone,visio,presentiel,technique,rh'],
            'date_heure'         => ['required', 'date'],
            'notes_preparation'  => ['nullable', 'string', 'max:5000'],
            'resultat'           => ['nullable', 'string', 'in:en_attente,positif,negatif,annule'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'       => 'Le type d\'entretien est obligatoire.',
            'type.in'             => 'Le type sélectionné est invalide.',
            'date_heure.required' => 'La date et l\'heure sont obligatoires.',
            'date_heure.date'     => 'La date et l\'heure doivent être valides.',
            'resultat.in'         => 'Le résultat sélectionné est invalide.',
        ];
    }
}
