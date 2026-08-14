@extends('layouts.app')

@section('title', 'Mis Solicitudes y Apartados - SGNIA Real Estate')

@section('content')
<!-- Client Dashboard Banner -->
<div class="bg-gradient-to-r from-slate-900 via-[#131927] to-[#0b0f19] text-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-slate-800">
    <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3.5 py-1 text-xs font-extrabold uppercase tracking-widest rounded-full bg-slate-800 text-slate-200 border border-slate-700">
                    👤 Comprador SGNIA
                </span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                Mis Solicitudes y Apartados - <span class="text-slate-300">{{ $user->name }}</span>
            </h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-1">
                Consulta tus mensajes enviados, confirma tus fichas aprobadas y procesa el pago de apartados con PayPal.
            </p>
        </div>

        <div>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-slate-100 hover:bg-white text-slate-950 font-black text-sm shadow-md transition">
                ← Explorar Inmuebles
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- KPI Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-slate-800 text-slate-300 border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Solicitudes Enviadas</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_requests'] }}</h3>
            </div>
        </div>

        <div class="bg-slate-900/90 p-6 rounded-3xl border border-amber-500/40 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-amber-500/10 text-amber-300 border border-amber-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400">Apartados Listos para Pagar</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['approved_requests'] }}</h3>
            </div>
        </div>

        <div class="bg-slate-900/90 p-6 rounded-3xl border border-emerald-500/40 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-emerald-500/10 text-emerald-300 border border-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400">Inmuebles Reservados</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['paid_requests'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Client Requests List -->
    <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden p-6 space-y-6 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Historial de Solicitudes y Apartados
                </h2>
                <p class="text-xs text-slate-400">Estado en tiempo real de tus consultas sobre propiedades en Nopalucan</p>
            </div>
            <span class="px-3 py-1 bg-slate-800 text-slate-200 font-extrabold text-xs rounded-full border border-slate-700">
                {{ $leads->count() }} Registro(s)
            </span>
        </div>

        <div class="space-y-4">
            @forelse($leads as $lead)
                <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 hover:border-slate-700 transition flex flex-col md:flex-row md:items-center justify-between gap-6">
                    
                    <!-- Property & Agent Info -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 max-w-2xl">
                        <!-- Thumbnail Image -->
                        <div class="w-24 h-24 rounded-2xl bg-slate-900 overflow-hidden shrink-0 border border-slate-800 relative">
                            @if($lead->property && $lead->property->images->isNotEmpty())
                                <img src="{{ $lead->property->images->first()->url }}" alt="{{ $lead->property->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-600 font-black text-xs">SGNIA</div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="space-y-1.5">
                            <span class="px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider rounded-md bg-slate-800 text-slate-300 border border-slate-700">
                                Folio: SGNIA-RES-2026-00{{ $lead->id }}
                            </span>
                            <h3 class="text-lg font-extrabold text-white">
                                @if($lead->property)
                                    <a href="{{ route('properties.show', $lead->property->id) }}" class="hover:underline" target="_blank">
                                        {{ $lead->property->title }}
                                    </a>
                                @else
                                    Propiedad Eliminada
                                @endif
                            </h3>
                            <p class="text-xs text-slate-400">
                                {{ $lead->property ? $lead->property->address : '-' }} • 
                                <span class="font-bold text-white">${{ number_format($lead->property ? $lead->property->price : 0, 0, ',', '.') }} MXN</span>
                            </p>
                            <p class="text-xs text-slate-400">
                                💼 Agente Asignado: <span class="text-slate-200 font-semibold">{{ $lead->property && $lead->property->user ? $lead->property->user->name : 'Agente SGNIA' }}</span>
                            </p>
                            <p class="text-xs text-slate-400 italic bg-slate-900/80 p-2.5 rounded-xl border border-slate-800/80 mt-1">
                                Tu mensaje: "{{ $lead->message }}"
                            </p>
                        </div>
                    </div>

                    <!-- Status & Action Button -->
                    <div class="flex flex-col items-start md:items-end justify-between gap-3 shrink-0 pt-4 md:pt-0 border-t md:border-t-0 border-slate-800">
                        <!-- Status Badge -->
                        <span class="px-3.5 py-1.5 text-xs font-black uppercase tracking-wider rounded-xl border 
                            {{ $lead->status === 'paid' ? 'bg-emerald-950 text-emerald-300 border-emerald-500/40' : '' }}
                            {{ $lead->status === 'approved' ? 'bg-amber-950 text-amber-300 border-amber-500/40 animate-pulse' : '' }}
                            {{ $lead->status === 'pending' ? 'bg-slate-900 text-slate-400 border-slate-800' : '' }}
                        ">
                            @if($lead->status === 'paid')
                                🎉 Reservado Exitosamente (Pagado)
                            @elseif($lead->status === 'approved')
                                ✅ Ficha Emitida - Pago Pendiente ($5 MXN)
                            @else
                                ⏳ Solicitud en Revisión
                            @endif
                        </span>

                        <!-- Action Button -->
                        <div>
                            @if($lead->status === 'approved')
                                <a href="{{ route('leads.receipt', $lead->id) }}" class="inline-flex items-center px-5 py-3 bg-slate-100 hover:bg-white text-slate-950 font-black text-xs rounded-2xl transition shadow-lg">
                                    💳 Pagar Apartado ($5.00 MXN) con PayPal →
                                </a>
                            @elseif($lead->status === 'paid')
                                <a href="{{ route('leads.receipt', $lead->id) }}" class="inline-flex items-center px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs rounded-xl transition border border-slate-700">
                                    📄 Ver Recibo Digital / Ficha SGNIA
                                </a>
                            @else
                                <span class="text-xs text-slate-500 font-medium italic">
                                    El agente responderá tu mensaje en breve
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-10 text-center space-y-4 bg-slate-950 rounded-2xl border border-slate-800">
                    <div class="w-16 h-16 rounded-full bg-slate-900 mx-auto flex items-center justify-center text-slate-500 text-2xl border border-slate-800">
                        🏡
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-white">No has realizado solicitudes de información aún</h3>
                        <p class="text-xs text-slate-400">Explora nuestro catálogo en Nopalucan y envía un mensaje sobre la propiedad de tu interés.</p>
                    </div>
                    <a href="{{ route('properties.index') }}" class="inline-block px-6 py-2.5 bg-slate-100 hover:bg-white text-slate-950 font-black text-xs rounded-xl transition">
                        Ver Inmuebles Disponibles
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
