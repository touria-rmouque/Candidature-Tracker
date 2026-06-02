<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;
use App\Models\Candidature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CandidatureController extends Controller
{
    public function index(Request $request): View
    {
        $query = Candidature::forUser(auth()->id())
            ->withCount('entretiens')
            ->orderByRaw("FIELD(priorite, 'haute', 'normale', 'basse')")
            ->orderBy('date_candidature', 'desc');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $candidatures = $query->paginate(15)->withQueryString();

        return view('candidatures.index', [
            'candidatures'   => $candidatures,
            'statuts'        => Candidature::STATUTS,
            'priorites'      => Candidature::PRIORITES,
            'filtreStatut'   => $request->statut,
            'filtrePriorite' => $request->priorite,
        ]);
    }

    public function create(): View
    {
        return view('candidatures.create', [
            'statuts'   => Candidature::STATUTS,
            'priorites' => Candidature::PRIORITES,
        ]);
    }

    public function store(StoreCandidatureRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('fichier')) {
            $fichier = $request->file('fichier');
            $data['fichier_path'] = $fichier->store('candidatures/' . auth()->id(), 'local');
            $data['fichier_nom']  = $fichier->getClientOriginalName();
        }

        unset($data['fichier']);
        $candidature = Candidature::create($data);

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature ajoutée avec succès !');
    }

    public function show(Candidature $candidature): View
    {
        $this->authorize('view', $candidature);

        $candidature->load('entretiens'); 

        return view('candidatures.show', [
            'candidature'    => $candidature,
            'typesEntretien' => \App\Models\Entretien::TYPES,
            'resultats'      => \App\Models\Entretien::RESULTATS,
        ]);
    }

    public function edit(Candidature $candidature): View
    {
        $this->authorize('update', $candidature);

        return view('candidatures.edit', [
            'candidature' => $candidature,
            'statuts'     => Candidature::STATUTS,
            'priorites'   => Candidature::PRIORITES,
        ]);
    }

    public function update(UpdateCandidatureRequest $request, Candidature $candidature): RedirectResponse
    {
        $this->authorize('update', $candidature);

        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            if ($candidature->fichier_path) {
                Storage::disk('local')->delete($candidature->fichier_path);
            }

            $fichier = $request->file('fichier');
            $data['fichier_path'] = $fichier->store('candidatures/' . auth()->id(), 'local');
            $data['fichier_nom']  = $fichier->getClientOriginalName();
        }

        unset($data['fichier']);
        $candidature->update($data);

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature mise à jour avec succès !');
    }

    public function destroy(Candidature $candidature): RedirectResponse
    {
        $this->authorize('delete', $candidature);

        $candidature->delete(); 

        return redirect()
            ->route('candidatures.index')
            ->with('success', 'Candidature archivée.');
    }

    public function archives(): View
    {
        $candidatures = Candidature::onlyTrashed()
            ->forUser(auth()->id()) 
            ->withCount('entretiens')
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('candidatures.archives', [
            'candidatures' => $candidatures,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $candidature);

        $candidature->restore();

        return redirect()
            ->route('candidatures.archives')
            ->with('success', 'Candidature restaurée dans votre liste active.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $candidature);

        if ($candidature->fichier_path && Storage::disk('local')->exists($candidature->fichier_path)) {
            Storage::disk('local')->delete($candidature->fichier_path);
        }

        $candidature->forceDelete();

        return redirect()
            ->route('candidatures.archives')
            ->with('success', 'La candidature a été supprimée définitivement.');
    }

    public function downloadFichier(Candidature $candidature)
    {
        $this->authorize('view', $candidature);

        if (!$candidature->fichier_path || !Storage::disk('local')->exists($candidature->fichier_path)) {
            abort(404, 'Fichier introuvable.');
        }

        return response()->download(
            Storage::disk('local')->path($candidature->fichier_path),
            $candidature->fichier_nom
        );
    }
}