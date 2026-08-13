@extends('layouts.app')

@section('title', 'Panel de Control - Administrador')

@section('content')
<div class="bg-slate-900 text-white py-10 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 to-slate-900 opacity-90"></div>
    <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <span class="px-3 py-1 text-xs font-extrabold uppercase rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                    {{ $user->role === 'admin' ? '👑 Administrador General' : '💼 Agente Inmobiliario' }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Panel de Control - {{ $user->name }}
            </h1>
            <p class="text-slate-300 text-sm mt-1">
                Gestión integral de inmuebles en Nopalucan y atención a clientes prospecto (Leads).
            </p>
        </div>

        <div>
            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold shadow-lg shadow-indigo-500/30 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Publicar Nuevo Inmueble
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- KPI Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 rounded-2xl bg-indigo-50 text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase text-slate-400">Total Inmuebles</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_properties'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase text-slate-400">Solicitudes Recibidas (Leads)</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_leads'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 rounded-2xl bg-blue-50 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase text-slate-400">Ubicación Principal</p>
                <h3 class="text-lg font-bold text-slate-800">Nopalucan, Pue.</h3>
            </div>
        </div>
    </div>

    <!-- Section 1: Leads Received from Buyers -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4 p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Solicitudes e Informes de Compradores (Leads)
                </h2>
                <p class="text-xs text-slate-500">Mensajes enviados por clientes interesados en las propiedades</p>
            </div>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 font-extrabold text-xs rounded-full">
                {{ $leads->count() }} Mensajes
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-xs">
                    <tr>
                        <th class="p-3">Comprador</th>
                        <th class="p-3">Propiedad</th>
                        <th class="p-3">Mensaje</th>
                        <th class="p-3">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-3">
                                <div class="font-bold text-slate-900">{{ $lead->user ? $lead->user->name : 'Usuario Anónimo' }}</div>
                                <div class="text-xs text-slate-400">{{ $lead->user ? $lead->user->email : '-' }}</div>
                            </td>
                            <td class="p-3 font-semibold text-indigo-600">
                                @if($lead->property)
                                    <a href="{{ route('properties.show', $lead->property->id) }}" class="hover:underline" target="_blank">
                                        {{ $lead->property->title }}
                                    </a>
                                @else
                                    Propiedad Eliminada
                                @endif
                            </td>
                            <td class="p-3 max-w-xs truncate text-slate-700">
                                "{{ $lead->message }}"
                            </td>
                            <td class="p-3 text-xs text-slate-400 whitespace-nowrap">
                                {{ $lead->created_at ? $lead->created_at->diffForHumans() : 'Reciente' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-400">
                                Aún no se han recibido solicitudes de información.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Manage Properties -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4 p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Listado y Gestión de Inmuebles
                </h2>
                <p class="text-xs text-slate-500">Inmuebles registrados en el portal</p>
            </div>
            <a href="{{ route('admin.properties.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-bold text-xs rounded-xl hover:bg-indigo-700 transition">
                + Agregar Inmueble
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-xs">
                    <tr>
                        <th class="p-3">Título</th>
                        <th class="p-3">Tipo</th>
                        <th class="p-3">Precio</th>
                        <th class="p-3">Dirección</th>
                        <th class="p-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($properties as $property)
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-3 font-bold text-slate-900">
                                {{ $property->title }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-xs font-extrabold uppercase rounded-lg border
                                    {{ $property->type === 'house' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                    {{ $property->type === 'apartment' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : '' }}
                                    {{ $property->type === 'commercial' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                                ">
                                    {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                                </span>
                            </td>
                            <td class="p-3 font-extrabold text-indigo-600">
                                ${{ number_format($property->price, 0, ',', '.') }} MXN
                            </td>
                            <td class="p-3 text-xs text-slate-500 max-w-xs truncate">
                                {{ $property->address }}
                            </td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('properties.show', $property->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white font-bold text-xs rounded-lg transition" target="_blank">
                                    Ver Ficha
                                </a>
                                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta propiedad?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-bold text-xs rounded-lg transition">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400">
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
