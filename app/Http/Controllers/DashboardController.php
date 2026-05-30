<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $allCandidatures = Candidature::forUser($userId)->get();
        $grouped = $allCandidatures->groupBy('statut');

        $stats = [
            'total'      => $allCandidatures->count(),
            'entretiens' => $grouped->get('entretien', collect())->count(),
            'offres'     => $grouped->get('offre', collect())->count() + $grouped->get('acceptee', collect())->count(),
            'archives'   => Candidature::onlyTrashed()->forUser($userId)->count(),
        ];

        $recentes = $allCandidatures->sortByDesc('created_at')->take(5);

        $prochainsEntretiens = Entretien::whereHas('candidature', fn($q) => $q->forUser($userId))
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->with('candidature')
            ->limit(4)
            ->get();

        $statsStatuts = $grouped->mapWithKeys(fn($items, $status) => [$status => $items->count()])->toArray();

        $chartData = [];
        $chartLabels = [];
        foreach (Candidature::STATUTS as $val => $label) {
            $chartData[] = $statsStatuts[$val] ?? 0;
            $chartLabels[] = $label; 
        }

        return view('dashboard', [
            'stats'               => $stats,
            'recentes'            => $recentes,
            'prochainsEntretiens' => $prochainsEntretiens,
            'statsStatuts'        => $statsStatuts,
            'statusConfig'        => Candidature::STATUS_CONFIG,
            'chartData'           => $chartData,
            'chartLabels'         => $chartLabels,
            'statutsList'         => Candidature::STATUTS
        ]);
    }
}