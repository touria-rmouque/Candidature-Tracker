@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('breadcrumb', 'Tableau de bord')

@section('content')
<div class="space-y-8 antialiased text-slate-600">

    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Bonjour, {{ explode(' ', auth()->user()->name)[0] }} 
            </h1>
            <p class="mt-1 text-sm text-slate-400 capitalize flex items-center gap-2">
                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->isoFormat('dddd D MMMM YYYY') }}
            </p>
        </div>
        <div>
            <a href="{{ route('candidatures.create') }}" class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-200 rounded-xl bg-slate-900 hover:bg-slate-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                <svg class="transition-transform group-hover:rotate-90" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle candidature
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total --}}
        <div class="relative overflow-hidden p-6 bg-white border border-slate-200/60 shadow-sm rounded-2xl group hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-5 -mt-5 transition-transform duration-300 group-hover:scale-110 rounded-full bg-slate-50"></div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-400">Total actives</p>
            <div class="relative flex items-baseline gap-2 mt-4">
                <span class="text-4xl font-extrabold tracking-tight text-slate-900">{{ $stats['total'] }}</span>
                <span class="text-xs font-medium text-slate-400">candidatures</span>
            </div>
        </div>

        <div class="relative overflow-hidden p-6 bg-white border border-slate-200/60 shadow-sm rounded-2xl group hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-5 -mt-5 transition-transform duration-300 group-hover:scale-110 rounded-full bg-amber-50/60"></div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-400">En entretien</p>
            <div class="relative flex items-baseline gap-2 mt-4">
                <span class="text-4xl font-extrabold tracking-tight text-amber-500">{{ $stats['entretiens'] }}</span>
                <span class="text-xs font-medium text-slate-400">en cours</span>
            </div>
        </div>

        <div class="relative overflow-hidden p-6 bg-white border border-slate-200/60 shadow-sm rounded-2xl group hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-5 -mt-5 transition-transform duration-300 group-hover:scale-110 rounded-full bg-emerald-50/60"></div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-400">Offres reçues</p>
            <div class="relative flex items-baseline gap-2 mt-4">
                <span class="text-4xl font-extrabold tracking-tight text-emerald-500">{{ $stats['offres'] }}</span>
                <span class="text-xs font-medium text-slate-400">offres</span>
            </div>
        </div>

        <div class="relative overflow-hidden p-6 bg-white border border-slate-200/60 shadow-sm rounded-2xl group hover:shadow-md transition-all duration-200">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-5 -mt-5 transition-transform duration-300 group-hover:scale-110 rounded-full bg-slate-50"></div>
            <p class="text-xs font-bold tracking-wider uppercase text-slate-400">Archivées</p>
            <div class="relative flex items-baseline gap-2 mt-4">
                <span class="text-4xl font-extrabold tracking-tight text-slate-400">{{ $stats['archives'] }}</span>
            </div>
            <p class="relative mt-3 text-xs">
                <a href="{{ route('candidatures.archives') }}" class="inline-flex items-center gap-1 font-semibold text-sky-600 transition-colors hover:text-sky-700">
                    Ouvrir les archives &rarr;
                </a>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="flex flex-col bg-white border border-slate-200/60 shadow-sm rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 bg-slate-100 text-slate-700 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </span>
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Candidatures récentes</h2>
                </div>
                <a href="{{ route('candidatures.index') }}" class="text-xs font-bold text-sky-600 transition-colors hover:text-sky-700">Voir tout &rarr;</a>
            </div>
            
            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentes as $c)
                    <a href="{{ route('candidatures.show', $c) }}" class="block transition-all duration-150 hover:bg-slate-50/80">
                        <div class="flex items-center gap-4 px-6 py-4">
                            <span class="flex h-2.5 w-2.5 shrink-0 rounded-full {{ $c->priorite === 'haute' ? 'bg-rose-500 animate-pulse' : ($c->priorite === 'normale' ? 'bg-slate-300' : 'bg-emerald-500') }}" aria-hidden="true"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $c->entreprise }}</p>
                                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $c->poste }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $c->statut_color ?? 'bg-slate-50 text-slate-600 ring-slate-500/10' }}">
                                {{ $c->statut_libelle }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-12">
                        <p class="text-sm text-slate-400">Aucune candidature pour l'instant.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="flex flex-col bg-white border border-slate-200/60 shadow-sm rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 bg-amber-50 text-amber-600 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Prochains entretiens</h2>
                </div>
            </div>
            
            <div class="divide-y divide-slate-100 flex-1">
                @forelse($prochainsEntretiens as $e)
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="flex flex-col items-center justify-center w-12 h-12 shrink-0 rounded-xl bg-slate-900 text-white shadow-sm">
                            <span class="text-base font-bold tracking-tight leading-none">{{ $e->date_heure->format('d') }}</span>
                            <span class="text-[9px] font-bold uppercase tracking-wider mt-1 text-slate-300">{{ $e->date_heure->isoFormat('MMM') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ $e->type_libelle }}</p>
                            <p class="text-xs text-slate-400 truncate mt-0.5">{{ $e->candidature->entreprise }}</p>
                        </div>
                        <div class="text-xs font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded-md shrink-0">
                            {{ $e->date_heure->format('H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-12">
                        <p class="text-sm text-slate-400">Aucun entretien à venir.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200/60 shadow-sm rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
            <span class="p-1.5 bg-sky-50 text-sky-600 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z"/>
                </svg>
            </span>
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">État du pipeline de recrutement</h2>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            @if($stats['total'] > 0)
                <div class="md:col-span-5 flex justify-center">
                    <div id="pipelineDonutChart" class="w-full max-w-[280px]"></div>
                </div>

                <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($statutsList as $val => $label)
                        @php
                            $count = $statsStatuts[$val] ?? 0;
                            $percentage = round(($count / $stats['total']) * 100);
                            $config = $statusConfig[$val] ?? ['text' => 'text-slate-500', 'color' => 'bg-slate-400'];
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-50 bg-slate-50/30">
                            <span class="w-3 h-3 rounded-full shrink-0 {{ $config['color'] }}"></span>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate capitalize">{{ $label }}</p>
                                <p class="text-sm font-black text-slate-900 mt-0.5">
                                    {{ $count }} <span class="text-xs font-medium text-slate-400">({{ $percentage }}%)</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-span-12 py-8 text-center">
                    <p class="text-sm text-slate-400">Aucune donnée disponible pour modéliser le graphique.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@if($stats['total'] > 0)
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartData = @json($chartData);
            const chartLabels = @json($chartLabels);
            const colorsPalette = @json(array_values(array_map(fn($c) => $c['hex'], $statusConfig)));

            const options = {
                series: chartData,
                labels: chartLabels,
                chart: {
                    type: 'donut',
                    height: 260,
                    fontFamily: 'Plus Jakarta Sans, Inter, sans-serif'
                },
                colors: colorsPalette,
                stroke: {
                    show: true,
                    colors: ['#ffffff'],
                    width: 3
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '12px',
                                    fontWeight: 700,
                                    color: '#94a3b8',
                                    offsetY: -4
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 800,
                                    color: '#0f172a',
                                    offsetY: 8,
                                    formatter: (val) => val
                                },
                                total: {
                                    show: true,
                                    label: 'Actives',
                                    color: '#64748b',
                                    fontWeight: 600,
                                    formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: (value) => `${value} candidature(s)`
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#pipelineDonutChart"), options);
            chart.render();
        });
    </script>
@endif
@endsection