@extends('layouts.app')

@section('title', 'Archives')
@section('breadcrumb', 'Archives')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Archives</h1>
        <p class="text-xs text-slate-400 mt-1">{{ $candidatures->total() }} candidature(s) archivée(s)</p>
    </div>
    <a href="{{ route('candidatures.index') }}" 
       class="inline-flex items-center justify-center gap-2 border border-slate-200 hover:border-slate-300 bg-white text-slate-600 hover:text-slate-800 rounded-xl px-4 py-2.5 text-xs font-semibold shadow-sm transition-all duration-150">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Candidatures actives
    </a>
</div>

<div class="space-y-3">
    @forelse($candidatures as $candidature)
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm opacity-70 hover:opacity-100 hover:shadow-md hover:border-sky-200 transition-all duration-200 overflow-hidden group">
            <div class="flex flex-col md:flex-row md:items-center justify-between">

                <div class="flex items-start md:items-center flex-1 min-w-0">
                    <div class="w-1.5 self-stretch shrink-0 bg-slate-300"></div>
                    
                    <div class="p-4 flex-1 min-w-0">
                        <div class="flex flex-wrap items-baseline gap-x-2">
                            <span class="text-sm font-bold text-slate-700 tracking-tight group-hover:text-slate-900 transition-colors">{{ $candidature->entreprise }}</span>
                            <span class="text-xs text-slate-400 truncate font-medium">{{ $candidature->poste }}</span>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600">
                                {{ $candidature->statut_libelle }}
                            </span>
                            
                            <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1 ml-1">
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Archivée le {{ $candidature->deleted_at->format('d/m/Y') }}
                            </span>

                            @if($candidature->entretiens_count > 0)
                                <span class="text-[11px] text-slate-400 font-medium">
                                    · {{ $candidature->entretiens_count }} @choice('entretien|entretiens', $candidature->entretiens_count)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1 px-4 pb-4 md:pb-0 md:py-0 shrink-0 border-t border-slate-50 md:border-t-0 md:bg-transparent">
                    <form method="POST" action="{{ route('candidatures.restore', $candidature->id) }}" class="w-full md:w-auto">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-sky-600 border border-slate-200 hover:border-sky-100 hover:bg-sky-50 px-3 py-2 rounded-xl cursor-pointer transition-all w-full md:w-auto">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Restaurer
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-12 px-4 bg-white border border-dashed border-slate-200 rounded-3xl">
            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl inline-flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800 tracking-tight">Aucune candidature archivée</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 leading-relaxed">
                Votre corbeille est vide. Les dossiers de candidature que vous décidez d'archiver viendront se placer dans cette section.
            </p>
        </div>
    @endforelse
</div>

@if($candidatures->hasPages())
    <div class="mt-6">
        {{ $candidatures->links() }}
    </div>
@endif

@endsection