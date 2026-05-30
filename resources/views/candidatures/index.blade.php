@extends('layouts.app')

@section('title', 'Mes candidatures')
@section('breadcrumb', 'Mes candidatures')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Mes candidatures</h1>
        <p class="text-xs text-slate-400 mt-1">{{ $candidatures->total() }} candidature(s) active(s)</p>
    </div>
    <a href="{{ route('candidatures.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-brand-950 hover:bg-slate-900 text-white rounded-xl px-4 py-2.5 text-xs font-semibold shadow-sm transition-all duration-150 group">
        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle candidature
    </a>
</div>

<form method="GET" action="{{ route('candidatures.index') }}" 
      class="bg-white border border-slate-200/60 rounded-2xl p-4 flex flex-wrap items-end gap-4 mb-6 shadow-sm">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-1.5 pl-0.5">Statut</label>
        <select name="statut" 
                class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 outline-none focus:border-sky-500 focus:bg-white transition-all cursor-pointer">
            <option value="">Tous les statuts</option>
            @foreach($statuts as $val => $label)
                <option value="{{ $val }}" {{ $filtreStatut === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="flex-1 min-w-[200px]">
        <label class="block text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-1.5 pl-0.5">Priorité</label>
        <select name="priorite" 
                class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 outline-none focus:border-sky-500 focus:bg-white transition-all cursor-pointer">
            <option value="">Toutes les priorités</option>
            @foreach($priorites as $val => $label)
                <option value="{{ $val }}" {{ $filtrePriorite === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center gap-2 pt-2 sm:pt-0">
        <button type="submit" 
                class="bg-sky-500 hover:bg-sky-600 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-sky-500/10 cursor-pointer transition-all">
            Filtrer
        </button>
        @if($filtreStatut || $filtrePriorite)
            <a href="{{ route('candidatures.index') }}" 
               class="border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-800 font-medium text-xs px-3 py-2.5 rounded-xl transition-all">
                Réinitialiser
            </a>
        @endif
    </div>
</form>

<div class="space-y-3">
    @forelse($candidatures as $candidature)
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm hover:shadow-md hover:border-sky-200 transition-all duration-200 overflow-hidden group">
            <div class="flex flex-col md:flex-row md:items-center justify-between">

                <div class="flex items-start md:items-center flex-1 min-w-0">
                    <div class="w-1.5 self-stretch shrink-0 
                        {{ $candidature->priorite === 'haute' ? 'bg-rose-500' : '' }}
                        {{ $candidature->priorite === 'normale' ? 'bg-amber-400' : '' }}
                        {{ $candidature->priorite === 'basse' ? 'bg-emerald-500' : '' }}">
                    </div>
                    
                    <div class="p-4 flex-1 min-w-0">
                        <div class="flex flex-wrap items-baseline gap-x-2">
                            <span class="text-sm font-bold text-slate-900 tracking-tight">{{ $candidature->entreprise }}</span>
                            <span class="text-xs text-slate-400 truncate font-medium">{{ $candidature->poste }}</span>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-700">
                                {{ $candidature->statut_libelle }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600">
                                {{ $candidature->priorite_libelle }}
                            </span>
                            
                            <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1 ml-1">
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $candidature->date_candidature->format('d/m/Y') }}
                            </span>

                            @if($candidature->entretiens_count > 0)
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-lg">
                                    <span class="w-1 h-1 rounded-full bg-sky-500 animate-pulse"></span>
                                    {{ $candidature->entretiens_count }} @choice('entretien|entretiens', $candidature->entretiens_count)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-1 px-4 pb-4 md:pb-0 md:py-0 shrink-0 border-t border-slate-50 md:border-t-0 md:bg-transparent">
                    <a href="{{ route('candidatures.show', $candidature) }}" 
                       class="text-xs font-semibold text-sky-600 hover:bg-sky-50 px-3 py-2 rounded-xl transition-all">
                        Voir
                    </a>
                    <a href="{{ route('candidatures.edit', $candidature) }}" 
                       class="text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-100 px-3 py-2 rounded-xl transition-all">
                        Modifier
                    </a>
                    <form method="POST" action="{{ route('candidatures.destroy', $candidature) }}"
                          onsubmit="return confirm('Archiver cette candidature ?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-xs font-medium text-slate-400 hover:text-rose-600 hover:bg-rose-50 px-3 py-2 rounded-xl cursor-pointer transition-all">
                            Archiver
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-12 px-4 bg-white border border-dashed border-slate-200 rounded-3xl">
            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl inline-flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800 tracking-tight">Aucune candidature trouvée</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 mb-5 leading-relaxed">
                @if($filtreStatut || $filtrePriorite)
                    Aucun dossier actif ne correspond aux critères de filtrage sélectionnés actuellement.
                @else
                    Votre tableau de bord est vide. Enregistrez dès maintenant vos démarches pour suivre vos processus de recrutement.
                @endif
            </p>
            <a href="{{ route('candidatures.create') }}" 
               class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition-all">
                Ajouter une candidature
            </a>
        </div>
    @endforelse
</div>

@if($candidatures->hasPages())
    <div class="mt-6">
        {{ $candidatures->links() }}
    </div>
@endif

@endsection