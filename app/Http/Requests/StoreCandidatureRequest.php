<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'entreprise'       => ['required', 'string', 'max:255'],
            'poste'            => ['required', 'string', 'max:255'],
            'url_offre'        => ['nullable', 'url', 'max:2048'],
            'statut'           => ['required', 'string', 'in:envoyee,relancee,entretien,test_tech,offre,acceptee,refusee,sans_suite'],
            'priorite'         => ['required', 'string', 'in:haute,normale,basse'],
            'notes'            => ['nullable', 'string', 'max:5000'],
            'date_candidature' => ['required', 'date'],
            'fichier'          => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5 Mo max
        ];
    }

    public function messages(): array
    {
        return [
            'entreprise.required'       => 'Le nom de l\'entreprise est obligatoire.',
            'poste.required'            => 'Le poste visé est obligatoire.',
            'url_offre.url'             => 'L\'URL de l\'offre doit être une adresse valide.',
            'statut.required'           => 'Le statut est obligatoire.',
            'statut.in'                 => 'Le statut sélectionné est invalide.',
            'priorite.required'         => 'La priorité est obligatoire.',
            'priorite.in'               => 'La priorité sélectionnée est invalide.',
            'date_candidature.required' => 'La date de candidature est obligatoire.',
            'date_candidature.date'     => 'La date de candidature doit être une date valide.',
            'fichier.file'              => 'Le fichier joint est invalide.',
            'fichier.mimes'             => 'Seuls les formats PDF, DOC et DOCX sont acceptés.',
            'fichier.max'               => 'Le fichier ne doit pas dépasser 5 Mo.',
        ];
    }
}
