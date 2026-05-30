@extends('layouts.app')

@section('title', $candidature->entreprise . ' — ' . $candidature->poste)
@section('breadcrumb', 'Détails de la candidature')
@section('content')

<div class="mb-6">
    <a href="{{ route('candidatures.index') }}" 
       class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight truncate">{{ $candidature->entreprise }}</h1>
                    <p class="text-sm font-medium text-slate-400 mt-0.5 truncate">{{ $candidature->poste }}</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('candidatures.edit', $candidature) }}"
                       class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 border border-slate-200 hover:border-slate-300 bg-white rounded-xl transition">
                        Modifier
                    </a>
                    <form method="POST" action="{{ route('candidatures.destroy', $candidature) }}"
                          onsubmit="return confirm('Archiver cette candidature ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-xs font-semibold text-slate-400 hover:text-rose-600 px-3 py-2 border border-slate-200 hover:border-rose-200 hover:bg-rose-50 rounded-xl cursor-pointer transition">
                            Archiver
                        </button>
                    </form>
                </div>
            </div>

            <div class="px-6 py-5 space-y-5">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold {{ $candidature->statut_color }}">
                        {{ $candidature->statut_libelle }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold {{ $candidature->priorite_color }}">
                        Priorité {{ $candidature->priorite_libelle }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600">
                        Envoyée le {{ $candidature->date_candidature->format('d/m/Y') }}
                    </span>
                </div>

                @if($candidature->url_offre)
                    <div>
                        <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-1.5 pl-0.5">Lien de l'offre</p>
                        <a href="{{ $candidature->url_offre }}" target="_blank" rel="noopener"
                           class="text-xs font-semibold text-sky-600 hover:text-sky-700 break-all inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ $candidature->url_offre }}
                        </a>
                    </div>
                @endif

                @if($candidature->notes)
                    <div>
                        <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-1.5 pl-0.5">Notes</p>
                        <p class="text-xs text-slate-600 whitespace-pre-line bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">{{ $candidature->notes }}</p>
                    </div>
                @endif

                @if($candidature->fichier_path)
                    <div>
                        <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-1.5 pl-0.5">Document joint</p>
                        <a href="{{ route('candidatures.fichier', $candidature) }}"
                           class="inline-flex items-center gap-2 text-xs font-semibold text-sky-600 hover:text-sky-700 px-3 py-2.5 bg-sky-50 hover:bg-sky-100 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                            {{ $candidature->fichier_nom }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900 tracking-tight">
                    Entretiens
                    @if($candidature->entretiens->count() > 0)
                        <span class="ml-1.5 text-xs font-normal text-slate-400">({{ $candidature->entretiens->count() }})</span>
                    @endif
                </h2>
                <a href="{{ route('entretiens.create', $candidature) }}"
                   class="text-xs font-semibold text-sky-600 hover:text-sky-700 px-3 py-2 border border-sky-100 hover:border-sky-200 bg-sky-50/50 hover:bg-sky-50 rounded-xl transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter
                </a>
            </div>

            @forelse($candidature->entretiens as $entretien)
                <div class="px-6 py-4 border-b border-slate-100/60 last:border-0 flex items-start gap-4 hover:bg-slate-50/30 transition group/row">
                    <div class="shrink-0 w-9 h-9 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center group-hover/row:bg-white group-hover/row:border-sky-200 transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover/row:text-sky-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="font-bold text-slate-800 text-xs">{{ $entretien->type_libelle }}</span>
                            <span class="text-slate-400 text-[11px] font-medium">{{ $entretien->date_heure->format('d/m/Y à H:i') }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $entretien->resultat_color }}">
                                {{ $entretien->resultat_libelle }}
                            </span>
                        </div>
                        @if($entretien->notes_preparation)
                            <p class="text-xs text-slate-500 truncate mt-0.5 leading-relaxed">{{ $entretien->notes_preparation }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover/row:opacity-100 focus-within:opacity-100 transition-opacity">
                        <a href="{{ route('entretiens.edit', [$candidature, $entretien]) }}"
                           class="text-[11px] font-semibold text-slate-500 hover:text-slate-800 px-2.5 py-1.5 hover:bg-slate-100 rounded-lg transition">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('entretiens.destroy', [$candidature, $entretien]) }}"
                              onsubmit="return confirm('Supprimer cet entretien ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[11px] font-semibold text-slate-400 hover:text-rose-600 px-2.5 py-1.5 hover:bg-rose-50 rounded-lg cursor-pointer transition">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center">
                    <p class="text-xs text-slate-400 font-medium">Aucun entretien enregistré pour l'instant.</p>
                    <a href="{{ route('entretiens.create', $candidature) }}"
                       class="inline-block mt-2 text-xs font-semibold text-sky-600 hover:text-sky-700">
                        Planifier le premier entretien →
                    </a>
                </div>
            @endforelse
        </div>

    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-5">
            <h3 class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-3 pl-0.5">Informations</h3>
            <dl class="space-y-3.5 text-xs font-medium">
                <div class="flex justify-between items-baseline">
                    <dt class="text-slate-400">Créée le</dt>
                    <dd class="text-slate-700 font-bold">{{ $candidature->date_candidature->format('d/m/Y') }}</dd>
                </div>
                <div class="flex justify-between items-baseline">
                    <dt class="text-slate-400">Dernière mise à jour</dt>
                    <dd class="text-slate-700 font-bold">{{ $candidature->updated_at->diffForHumans() }}</dd>
                </div>
                <div class="flex justify-between items-baseline">
                    <dt class="text-slate-400">Total entretiens</dt>
                    <dd class="text-slate-700 font-bold">{{ $candidature->entretiens->count() }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-5">
            <h3 class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-3 pl-0.5">Actions rapides</h3>
            <div class="space-y-1">
                <a href="{{ route('candidatures.edit', $candidature) }}"
                   class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition w-full group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier la candidature
                </a>
                <a href="{{ route('entretiens.create', $candidature) }}"
                   class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition w-full group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter un entretien
                </a>
            </div>
        </div>
    </div>
</div>

@endsection