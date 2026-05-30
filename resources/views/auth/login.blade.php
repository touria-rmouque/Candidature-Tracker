<x-guest-layout>
    <x-auth-session-status class="mb-4 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3" :status="session('status')" />

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-6 text-center sm:text-left">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Connexion</h1>
            <p class="text-[11px] font-medium text-slate-400 mt-0.5">Accédez à votre espace de suivi de candidatures.</p>
        </div>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" 
               class="inline-flex items-center justify-center text-xs font-semibold text-sky-600 hover:text-sky-700 bg-sky-50 hover:bg-sky-100/70 border border-sky-100 px-3 py-1.5 rounded-xl transition w-fit mx-auto sm:mx-0">
                Créer un compte
            </a>
        @endif
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <x-input-label for="email" :value="__('Adresse e-mail')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="email" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none" 
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="block text-xs font-bold text-slate-700 tracking-wide uppercase mb-1.5 pl-0.5" />
                <x-text-input id="password" 
                              class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none"
                              type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="text-rose-600 text-[11px] font-semibold mt-1.5 pl-0.5" />
            </div>
        </div>

        <div class="block mt-4 pl-0.5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-sky-500/20 focus:border-sky-500 w-4 h-4 cursor-pointer" 
                       name="remember">
                <span class="ms-2 text-xs font-medium text-slate-500 hover:text-slate-700 transition">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6 pt-5 border-t border-slate-100">
            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition underline underline-offset-4" 
                   href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <button type="submit" 
                    class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition cursor-pointer text-center">
                {{ __('Se connecter') }}
            </button>
        </div>
    </form>
</x-guest-layout>