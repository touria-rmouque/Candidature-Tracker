@extends('layouts.app')

@section('title', 'Modifier — ' . $candidature->entreprise)
@section('breadcrumb', 'Modifier la candidature')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('candidatures.show', $candidature) }}" 
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour au détail
        </a>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight mt-2">
            Modifier — {{ $candidature->entreprise }}
        </h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-6">
        <form method="POST" action="{{ route('candidatures.update', $candidature) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="entreprise">
                        Entreprise <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="entreprise" name="entreprise"
                           value="{{ old('entreprise', $candidature->entreprise) }}"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('entreprise') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('entreprise')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="poste">
                        Poste visé <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="poste" name="poste"
                           value="{{ old('poste', $candidature->poste) }}"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('poste') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('poste')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="url_offre">
                        URL de l'offre <span class="text-slate-400 font-normal">(optionnel)</span>
                    </label>
                    <input type="url" id="url_offre" name="url_offre"
                           value="{{ old('url_offre', $candidature->url_offre) }}"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('url_offre') !border-rose-500 ring-rose-500/10 @enderror"
                           placeholder="https://...">
                    @error('url_offre')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="statut">
                            Statut <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="statut" name="statut"
                                    class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none appearance-none cursor-pointer">
                                @foreach($statuts as $val => $label)
                                    <option value="{{ $val }}" {{ old('statut', $candidature->statut) === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="priorite">
                            Priorité <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="priorite" name="priorite"
                                    class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none appearance-none cursor-pointer">
                                @foreach($priorites as $val => $label)
                                    <option value="{{ $val }}" {{ old('priorite', $candidature->priorite) === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="date_candidature">
                        Date de candidature <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="date_candidature" name="date_candidature"
                           value="{{ old('date_candidature', $candidature->date_candidature->format('Y-m-d')) }}"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('date_candidature') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('date_candidature')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="notes">
                        Notes libres <span class="text-slate-400 font-normal">(optionnel)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none leading-relaxed @error('notes') !border-rose-500 ring-rose-500/10 @enderror"
                              placeholder="Détails, retours particuliers, arguments clés...">{{ old('notes', $candidature->notes) }}</textarea>
                    @error('notes')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="fichier">
                        Document joint <span class="text-slate-400 font-normal lowercase">(remplace le fichier existant)</span>
                    </label>
                    
                    @if($candidature->fichier_nom)
                        <div class="mb-3 flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 w-fit">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Fichier actuel : <span class="font-bold text-slate-700">{{ $candidature->fichier_nom }}</span>
                        </div>
                    @endif

                    <input type="file" id="fichier" name="fichier"
                           accept=".pdf,.doc,.docx"
                           class="w-full text-xs text-slate-500 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 file:cursor-pointer cursor-pointer">
                    @error('fichier')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
                <a href="{{ route('candidatures.show', $candidature) }}"
                   class="text-xs font-semibold text-slate-600 px-4 py-2.5 rounded-xl hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@endsection