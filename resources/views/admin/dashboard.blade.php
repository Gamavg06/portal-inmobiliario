@extends('layouts.app')

@section('title', 'Panel de Control - SGNIA Real Estate')

@section('content')
<!-- Dashboard Banner -->
<div class="bg-gradient-to-r from-slate-900 via-[#131927] to-[#0b0f19] text-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-slate-800">
    <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3.5 py-1 text-xs font-extrabold uppercase tracking-widest rounded-full bg-slate-800 text-slate-200 border border-slate-700">
                    {{ $user->role === 'admin' ? '👑 Administrador General' : '💼 Agente SGNIA' }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                Panel SGNIA - <span class="text-slate-300">{{ $user->name }}</span>
            </h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-1">
                Gestión de propiedades geolocalizadas y atención a prospectos en Nopalucan de la Granja, Puebla.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-slate-100 hover:bg-white text-slate-950 font-black text-sm shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Publicar Inmueble
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Total Inmuebles</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_properties'] }}</h3>
            </div>
        </div>

        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-slate-800 text-slate-300 border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Agentes Pendientes</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['pending_agents'] ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-slate-800 text-slate-300 border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Solicitudes Recibidas (Leads)</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_leads'] }}</h3>
            </div>
        </div>
    </div>

    @if($user->role === 'admin' && isset($pendingAgents) && $pendingAgents->isNotEmpty())
        <!-- Section: Pending Agents Approval -->
        <div class="bg-slate-900/90 rounded-3xl border border-amber-500/40 shadow-2xl overflow-hidden space-y-4 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Agentes Inmobiliarios Pendientes de Aprobación
                    </h2>
                    <p class="text-xs text-slate-400">Solicitudes de registro de agentes que requieren tu confirmación para poder ingresar</p>
                </div>
                <span class="px-3 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/30 font-extrabold text-xs rounded-full">
                    {{ $pendingAgents->count() }} Pendiente(s)
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3">Nombre</th>
                            <th class="p-3">Correo Electrónico</th>
                            <th class="p-3">Fecha Solicitud</th>
                            <th class="p-3 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80 font-medium text-xs sm:text-sm">
                        @foreach($pendingAgents as $agent)
                            <tr class="hover:bg-slate-800/50">
                                <td class="p-3 font-bold text-white">{{ $agent->name }}</td>
                                <td class="p-3 text-slate-300">{{ $agent->email }}</td>
                                <td class="p-3 text-xs text-slate-400">{{ $agent->created_at ? $agent->created_at->diffForHumans() : 'Reciente' }}</td>
                                <td class="p-3 text-right">
                                    <form action="{{ route('admin.agents.approve', $agent->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs rounded-xl transition shadow-md">
                                            ✓ Aprobar y Activar Agente
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Section 1: Leads Received from Buyers -->
    <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden p-6 space-y-6 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Solicitudes de Compradores (Leads)
                </h2>
                <p class="text-xs text-slate-400">Mensajes recibidos de clientes interesados y gestión de apartados</p>
            </div>
            <span class="px-3 py-1 bg-slate-800 text-slate-200 font-extrabold text-xs rounded-full border border-slate-700">
                {{ $leads->count() }} Mensajes
            </span>
        </div>

        <!-- Responsive Card List for Leads -->
        <div class="space-y-4">
            @forelse($leads as $lead)
                <div class="p-5 rounded-2xl bg-slate-950 border border-slate-800/80 hover:border-slate-700 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    <!-- Left: Customer & Message -->
                    <div class="space-y-2 max-w-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-800 text-white font-extrabold flex items-center justify-center text-xs border border-slate-700">
                                {{ strtoupper(substr($lead->user ? $lead->user->name : 'U', 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-extrabold text-white text-sm leading-tight">{{ $lead->user ? $lead->user->name : 'Usuario Anónimo' }}</h4>
                                <p class="text-xs text-slate-400 font-mono">{{ $lead->user ? $lead->user->email : '-' }}</p>
                            </div>
                        </div>

                        <div class="pl-12 space-y-1">
                            <p class="text-xs font-semibold text-slate-300">
                                Inmueble: 
                                @if($lead->property)
                                    <a href="{{ route('properties.show', $lead->property->id) }}" class="text-white hover:underline font-extrabold" target="_blank">
                                        {{ $lead->property->title }}
                                    </a>
                                @else
                                    <span class="text-rose-400">Propiedad Eliminada</span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-400 italic bg-slate-900/80 p-3 rounded-xl border border-slate-800/60">
                                "{{ $lead->message }}"
                            </p>
                        </div>
                    </div>

                    <!-- Right: Status Badge & Action Buttons -->
                    <div class="flex flex-col sm:flex-row md:flex-col items-start md:items-end justify-between gap-3 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-slate-800">
                        <span class="px-3 py-1 text-xs font-black uppercase tracking-wider rounded-xl border 
                            {{ $lead->status === 'paid' ? 'bg-emerald-950 text-emerald-300 border-emerald-500/30' : '' }}
                            {{ $lead->status === 'approved' ? 'bg-amber-950 text-amber-300 border-amber-500/30' : '' }}
                            {{ $lead->status === 'pending' ? 'bg-slate-900 text-slate-300 border-slate-700' : '' }}
                        ">
                            {{ $lead->status === 'paid' ? '🎉 Reservado (Pagado)' : ($lead->status === 'approved' ? '✅ Ficha Emitida ($5 MXN)' : '⏳ Pendiente de Aprobación') }}
                        </span>

                        <div>
                            @if($lead->status === 'pending')
                                <form action="{{ route('admin.leads.approve', $lead->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="reservation_amount" value="5.00">
                                    <button type="submit" class="px-4 py-2.5 bg-slate-100 hover:bg-white text-slate-950 font-black text-xs rounded-xl transition shadow-md">
                                        ✓ Aprobar y Solicitar Apartado ($5 MXN)
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('leads.receipt', $lead->id) }}" class="inline-flex items-center px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs rounded-xl transition border border-slate-700 shadow-sm" target="_blank">
                                    📄 Ver Ficha / Pagar con PayPal →
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-8 text-center text-slate-500 bg-slate-950 rounded-2xl border border-slate-800">
                    Aún no se han recibido solicitudes de información de compradores.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Section 2: Manage Properties -->
    <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden space-y-4 p-6 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Gestión de Inmuebles
                </h2>
                <p class="text-xs text-slate-400">Publicaciones registradas en Nopalucan</p>
            </div>
            <a href="{{ route('admin.properties.create') }}" class="px-4 py-2 bg-slate-100 hover:bg-white text-slate-950 font-bold text-xs rounded-xl transition">
                + Agregar Inmueble
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3">Título</th>
                        <th class="p-3">Tipo</th>
                        <th class="p-3">Precio</th>
                        <th class="p-3">Dirección</th>
                        <th class="p-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80 font-medium text-xs sm:text-sm">
                    @forelse($properties as $property)
                        <tr class="hover:bg-slate-800/50">
                            <td class="p-3 font-bold text-white">
                                {{ $property->title }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border bg-slate-950 text-slate-300 border-slate-700">
                                    {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                                </span>
                            </td>
                            <td class="p-3 font-black text-white">
                                ${{ number_format($property->price, 0, ',', '.') }} MXN
                            </td>
                            <td class="p-3 text-xs text-slate-400 max-w-xs truncate">
                                {{ $property->address }}
                            </td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('properties.show', $property->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-lg transition border border-slate-700" target="_blank">
                                    Ver Ficha
                                </a>
                                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta propiedad?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-950/80 hover:bg-rose-600 text-rose-300 hover:text-white font-bold text-xs rounded-lg transition border border-rose-800/60">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-500">
                                No hay propiedades registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
