<x-guest-layout>
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-6 text-center sm:text-left">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Inscription</h1>
            <p class="text-[11px] font-medium text-slate-400 mt-0.5">Créez votre compte pour suivre vos candidatures.</p>
        </div>
        <a href="{{ route('login') }}" 
           class="inline-flex items-center justify-center text-xs font-semibold text-sky-600 hover:text-sky-700 bg-sky-50 hover:bg-sky-100/70 border border-sky-100 px-3 py-1.5 rounded-xl transition w-fit mx-auto sm:mx-0">
            Se connecter
        </a>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <x-input-label for="name" :value="__('Nom')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="name" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none" 
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Adresse e-mail')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="email" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none" 
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="password" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="password_confirmation" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6 pt-5 border-t border-slate-100">
            <a class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition underline underline-offset-4 text-center sm:text-left" 
               href="{{ route('login') }}">
                Déjà inscrit ?
            </a>

            <button type="submit" 
                    class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer text-center">
                Créer mon compte
            </button>
        </div>
    </form>
</x-guest-layout>