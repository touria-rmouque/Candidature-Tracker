<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CandidatureTracker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#F0F7FF',
                            100: '#E0EFFF',
                            500: '#0EA5E9',
                            600: '#0284C7',
                            900: '#0C1B2E',
                            950: '#060D17',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-slate-50/50 text-slate-600 font-sans antialiased">

@auth
    <aside class="fixed inset-y-0 left-0 w-64 border-r border-slate-200/60 bg-brand-950 flex flex-col z-50">

        <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-sky-500/10 to-transparent pointer-events-none"></div>

        <div class="relative px-6 py-5 border-b border-white/[0.04] flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 no-underline group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-400 to-sky-500 flex items-center justify-center shadow-lg shadow-sky-500/20 group-hover:scale-105 transition-transform duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 12h6M9 16h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="text-white text-sm font-bold tracking-tight">
                    CandidatureTracker
                </span>
            </a>
        </div>

        <nav class="relative flex-1 overflow-y-auto px-4 py-6 space-y-7">

            <div class="space-y-1.5">
                <div class="text-[10px] font-bold tracking-wider uppercase text-slate-500 px-3">
                    Général
                </div>
                <a href="{{ route('dashboard') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 relative
                   {{ request()->routeIs('dashboard')
                       ? 'bg-white/[0.07] text-sky-400'
                       : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}">
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-sky-400 rounded-r-md"></span>
                    @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>
            </div>

            <div class="space-y-1.5">
                <div class="text-[10px] font-bold tracking-wider uppercase text-slate-500 px-3">
                    Candidatures
                </div>
                
                @php $candActive = request()->routeIs('candidatures.index') || request()->routeIs('candidatures.show') || request()->routeIs('candidatures.edit'); @endphp
                <a href="{{ route('candidatures.index') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 relative
                   {{ $candActive ? 'bg-white/[0.07] text-sky-400' : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}">
                    @if($candActive)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-sky-400 rounded-r-md"></span>
                    @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Mes candidatures
                </a>

                <a href="{{ route('candidatures.create') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 relative
                   {{ request()->routeIs('candidatures.create') ? 'bg-white/[0.07] text-sky-400' : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}">
                    @if(request()->routeIs('candidatures.create'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-sky-400 rounded-r-md"></span>
                    @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle candidature
                </a>

                <a href="{{ route('candidatures.archives') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 relative
                   {{ request()->routeIs('candidatures.archives') ? 'bg-white/[0.07] text-sky-400' : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}">
                    @if(request()->routeIs('candidatures.archives'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-sky-400 rounded-r-md"></span>
                    @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Archives
                </a>
            </div>

            <div class="space-y-1.5">
                <div class="text-[10px] font-bold tracking-wider uppercase text-slate-500 px-3">
                    Configuration
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 relative
                   {{ request()->routeIs('profile.*') ? 'bg-white/[0.07] text-sky-400' : 'text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}">
                    @if(request()->routeIs('profile.*'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-sky-400 rounded-r-md"></span>
                    @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-white/[0.04] bg-brand-950/40">
            <div class="flex items-center gap-3 px-2 py-1.5 mb-3">
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-xs font-bold text-white shadow-inner">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-brand-950"></span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-slate-200 text-xs font-bold truncate tracking-tight">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-slate-500 text-[11px] truncate mt-0.5">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 border border-white/[0.06] text-slate-400 hover:border-rose-500/30 hover:text-rose-400 hover:bg-rose-500/[0.06] rounded-xl py-2 text-xs font-medium cursor-pointer transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </aside>

    <div class="pl-64 min-h-screen flex flex-col">

        <header class="sticky top-0 z-40 h-14 bg-slate-50/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8">
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                @yield('breadcrumb', 'Dashboard')
            </div>
            
            <div class="flex items-center gap-3">
                @if(session('success'))
                    <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200/60 text-emerald-800 rounded-xl px-4 py-1.5 text-xs font-medium shadow-sm animate-fade-in">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-2 bg-rose-50 border border-rose-200/60 text-rose-800 rounded-xl px-4 py-1.5 text-xs font-medium shadow-sm animate-fade-in">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </header>

        <main class="flex-1 p-8 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

@else

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-brand-50 to-blue-50/50 p-6">
        <div class="w-full max-w-md bg-white border border-slate-200/60 p-8 rounded-3xl shadow-xl shadow-slate-200/50">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-500 flex items-center justify-center shadow-lg shadow-sky-500/30">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <path d="M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <path d="M9 12h6M9 16h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                    CandidatureTracker
                </h1>
                <p class="text-xs text-slate-400 mt-1">
                    Centralisez et propulsez vos recherches d'emploi
                </p>
            </div>
            
            @yield('content')
        </div>
    </div>

@endauth

</body>
</html>