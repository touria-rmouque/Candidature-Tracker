@extends('layouts.app')

@section('title', 'Mon profil')
@section('breadcrumb', 'Mon profil')

@section('content')

<div class="max-w-xl mx-auto">
    {{-- TITRE DE LA PAGE --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Mon profil</h1>
    </div>

    {{-- ── BLOC : INFOS DU PROFIL ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-6 mb-5">
        <div class="mb-5">
            <h2 class="text-xs font-bold text-slate-900 tracking-wide uppercase">
                Informations du profil
            </h2>
            <p class="text-[11px] font-medium text-slate-400 mt-0.5">
                Modifiez votre nom et votre adresse e-mail.
            </p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="space-y-4">
                {{-- Nom --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="name">
                        Nom
                    </label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $user->name) }}" required autofocus
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('name') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('name')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Adresse e-mail --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="email">
                        Adresse e-mail
                    </label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email', $user->email) }}" required
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('email') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('email')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Footer d'action --}}
            <div class="flex items-center gap-4 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" 
                        class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                    Enregistrer
                </button>
                @if(session('status') === 'profile-updated')
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Sauvegardé
                    </span>
                @endif
            </div>
        </form>
    </div>

    {{-- ── BLOC : CHANGER LE MOT DE PASSE ────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-6 mb-5">
        <div class="mb-5">
            <h2 class="text-xs font-bold text-slate-900 tracking-wide uppercase">
                Changer le mot de passe
            </h2>
            <p class="text-[11px] font-medium text-slate-400 mt-0.5">
                Utilisez un mot de passe long et aléatoire pour garantir votre sécurité.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="space-y-4">
                {{-- Mot de passe actuel --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="current_password">
                        Mot de passe actuel
                    </label>
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('current_password', 'updatePassword') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('current_password', 'updatePassword')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nouveau mot de passe --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="password">
                        Nouveau mot de passe
                    </label>
                    <input type="password" id="password" name="password" autocomplete="new-password"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('password', 'updatePassword') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('password', 'updatePassword')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmer le mot de passe --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" for="password_confirmation">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none @error('password_confirmation', 'updatePassword') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Footer d'action --}}
            <div class="flex items-center gap-4 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" 
                        class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                    Mettre à jour
                </button>
                @if(session('status') === 'password-updated')
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Mot de passe mis à jour
                    </span>
                @endif
            </div>
        </form>
    </div>

    {{-- ── BLOC : ZONE DE DANGER (SUPPRESSION) ─────────────────────────────── --}}
    <div class="bg-rose-50/30 rounded-2xl border border-rose-200 shadow-sm p-6">
        <div class="mb-5">
            <h2 class="text-xs font-bold text-rose-800 tracking-wide uppercase">
                Supprimer le compte
            </h2>
            <p class="text-[11px] font-medium text-rose-600/80 mt-0.5">
                Une fois supprimé, toutes vos données seront effacées définitivement et cette action est irréversible.
            </p>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est définitive.')">
            @csrf
            @method('delete')

            <div class="space-y-4">
                {{-- Validation de mot de passe avant suppression --}}
                <div>
                    <label class="block text-xs font-bold text-rose-800/90 tracking-wide uppercase mb-1.5 pl-0.5" for="delete_password">
                        Confirmez avec votre mot de passe
                    </label>
                    <input type="password" id="delete_password" name="password" 
                           placeholder="Votre mot de passe actuel"
                           class="w-full bg-white border border-rose-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-rose-300 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition-all outline-none @error('password', 'userDeletion') !border-rose-500 ring-rose-500/10 @enderror">
                    @error('password', 'userDeletion')
                        <p class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-rose-100">
                <button type="submit" 
                        class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                    Supprimer mon compte
                </button>
            </div>
        </form>
    </div>
</div>

@endsection