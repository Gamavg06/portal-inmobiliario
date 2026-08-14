@extends('layouts.app')

@section('title', 'Panel de Control - SGNIA Real Estate')

@section('content')
<div class="bg-[#0b0817] text-white py-10 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-[#ff2a85]/20">
    <div class="absolute inset-0 bg-gradient-to-r from-[#ff2a85]/10 via-purple-900/20 to-transparent"></div>
    <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3.5 py-1 text-xs font-black uppercase tracking-widest rounded-full bg-[#ff2a85]/20 text-[#ff2a85] border border-[#ff2a85]/30">
                    {{ $user->role === 'admin' ? '👑 Administrador General' : '💼 Agente SGNIA' }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight">
                Panel SGNIA - <span class="text-[#ff2a85]">{{ $user->name }}</span>
            </h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-1">
                Gestión de propiedades geolocalizadas y atención a prospectos en Nopalucan de la Granja, Puebla.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-gradient-to-r from-[#ff2a85] to-purple-600 hover:from-[#e01f73] hover:to-purple-700 text-white font-black text-sm shadow-neon transition">
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
        <div class="bg-[#110d22]/90 p-6 rounded-3xl border border-slate-800/80 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-[#ff2a85]/10 text-[#ff2a85] border border-[#ff2a85]/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Total Inmuebles</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_properties'] }}</h3>
            </div>
        </div>

        <div class="bg-[#110d22]/90 p-6 rounded-3xl border border-slate-800/80 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-purple-500/10 text-purple-400 border border-purple-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Solicitudes Recibidas (Leads)</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_leads'] }}</h3>
            </div>
        </div>

        <div class="bg-[#110d22]/90 p-6 rounded-3xl border border-slate-800/80 shadow-xl flex items-center space-x-4 backdrop-blur-xl">
            <div class="p-4 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Ubicación Principal</p>
                <h3 class="text-lg font-black text-white">Nopalucan, Pue.</h3>
            </div>
        </div>
    </div>

    <!-- Section 1: Leads Received from Buyers -->
    <div class="bg-[#110d22]/90 rounded-3xl border border-slate-800/80 shadow-2xl overflow-hidden space-y-4 p-6 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <h2 class="text-xl font-black text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#ff2a85]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Solicitudes de Compradores (Leads)
                </h2>
                <p class="text-xs text-slate-400">Mensajes recibidos de clientes interesados</p>
            </div>
            <span class="px-3 py-1 bg-[#ff2a85]/20 text-[#ff2a85] font-extrabold text-xs rounded-full border border-[#ff2a85]/30">
                {{ $leads->count() }} Mensajes
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-[#090710] text-[#ff2a85] font-extrabold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3">Comprador</th>
                        <th class="p-3">Propiedad</th>
                        <th class="p-3">Mensaje</th>
                        <th class="p-3">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80 font-medium text-xs sm:text-sm">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-[#16102c]/50">
                            <td class="p-3">
                                <div class="font-bold text-white">{{ $lead->user ? $lead->user->name : 'Usuario Anónimo' }}</div>
                                <div class="text-xs text-slate-400">{{ $lead->user ? $lead->user->email : '-' }}</div>
                            </td>
                            <td class="p-3 font-semibold text-[#ff2a85]">
                                @if($lead->property)
                                    <a href="{{ route('properties.show', $lead->property->id) }}" class="hover:underline" target="_blank">
                                        {{ $lead->property->title }}
                                    </a>
                                @else
                                    Propiedad Eliminada
                                @endif
                            </td>
                            <td class="p-3 max-w-xs truncate text-slate-300">
                                "{{ $lead->message }}"
                            </td>
                            <td class="p-3 text-xs text-slate-400 whitespace-nowrap">
                                {{ $lead->created_at ? $lead->created_at->diffForHumans() : 'Reciente' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-500">
                                Aún no se han recibido solicitudes de información.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Manage Properties -->
    <div class="bg-[#110d22]/90 rounded-3xl border border-slate-800/80 shadow-2xl overflow-hidden space-y-4 p-6 backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
            <div>
                <h2 class="text-xl font-black text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#ff2a85]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Gestión de Inmuebles
                </h2>
                <p class="text-xs text-slate-400">Publicaciones registradas en Nopalucan</p>
            </div>
            <a href="{{ route('admin.properties.create') }}" class="px-4 py-2 bg-[#ff2a85] text-white font-bold text-xs rounded-xl hover:bg-[#e01f73] transition">
                + Agregar Inmueble
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-[#090710] text-[#ff2a85] font-extrabold uppercase text-[10px] tracking-wider">
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
                        <tr class="hover:bg-[#16102c]/50">
                            <td class="p-3 font-bold text-white">
                                {{ $property->title }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border
                                    {{ $property->type === 'house' ? 'bg-emerald-950/80 text-emerald-400 border-emerald-500/40' : '' }}
                                    {{ $property->type === 'apartment' ? 'bg-purple-950/80 text-purple-300 border-purple-500/40' : '' }}
                                    {{ $property->type === 'commercial' ? 'bg-rose-950/80 text-rose-400 border-rose-500/40' : '' }}
                                ">
                                    {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                                </span>
                            </td>
                            <td class="p-3 font-black text-[#ff2a85]">
                                ${{ number_format($property->price, 0, ',', '.') }} MXN
                            </td>
                            <td class="p-3 text-xs text-slate-400 max-w-xs truncate">
                                {{ $property->address }}
                            </td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('properties.show', $property->id) }}" class="inline-flex items-center px-3 py-1.5 bg-[#17122b] hover:bg-[#ff2a85] text-white font-bold text-xs rounded-lg transition" target="_blank">
                                    Ver Ficha
                                </a>
                                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta propiedad?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-950/80 hover:bg-rose-600 text-rose-300 hover:text-white font-bold text-xs rounded-lg transition border border-rose-500/40">
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
