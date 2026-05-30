@extends('layouts.app')

@section('title', 'Nouvel entretien')
@section('breadcrumb', 'Ajouter un entretien')
@section('content')

    <div class="max-w-xl mx-auto antialiased">
        <div class="mb-6">
            <a href="{{ route('candidatures.show', $candidature) }}" class="group text-xs font-bold text-sky-600 hover:text-sky-700 uppercase tracking-wider flex items-center gap-1.5 w-fit transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour à {{ $candidature->entreprise }}
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-2 sm:text-3xl">Nouvel entretien</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">{{ $candidature->entreprise }} — <span class="text-slate-500">{{ $candidature->poste }}</span></p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-6 sm:p-8">
            <form method="POST" action="{{ route('entretiens.store', $candidature) }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2" for="type">
                            Type d'entretien <span class="text-rose-500">*</span>
                        </label>
                        <select id="type" name="type"
                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition focus:bg-white focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 focus:outline-none @error('type') border-rose-500 bg-rose-50/30 @enderror">
                            <option value="">Choisir un type...</option>
                            @foreach($types as $val => $label)
                                <option value="{{ $val }}" {{ old('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2" for="date_heure">
                            Date et heure <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local" id="date_heure" name="date_heure"
                               value="{{ old('date_heure') }}"
                               class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition focus:bg-white focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 focus:outline-none @error('date_heure') border-rose-500 bg-rose-50/30 @enderror">
                        @error('date_heure')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2" for="resultat">
                            Résultat <span class="text-slate-400 font-normal lowercase italic">(optionnel)</span>
                        </label>
                        <select id="resultat" name="resultat"
                                class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition focus:bg-white focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 focus:outline-none">
                            <option value="">Non renseigné</option>
                            @foreach($resultats as $val => $label)
                                <option value="{{ $val }}" {{ old('resultat') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2" for="notes_preparation">
                            Notes de préparation <span class="text-slate-400 font-normal lowercase italic">(optionnel)</span>
                        </label>
                        <textarea id="notes_preparation" name="notes_preparation" rows="4"
                                  placeholder="Questions à poser, points clés à préparer, recherches sur l'entreprise..."
                                  class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 transition placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 focus:outline-none @error('notes_preparation') border-rose-500 bg-rose-50/30 @enderror">{{ old('notes_preparation') }}</textarea>
                        @error('notes_preparation')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                <span class="w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('candidatures.show', $candidature) }}"
                       class="w-full sm:w-auto text-center text-sm font-semibold text-slate-600 px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto bg-slate-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-slate-800 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        Ajouter l'entretien
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection