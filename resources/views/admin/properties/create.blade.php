@extends('layouts.app')

@section('title', 'Publicar Inmueble - SGNIA Real Estate')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl p-8 space-y-8 backdrop-blur-xl">
        
        <!-- Header -->
        <div class="border-b border-slate-800 pb-6 flex items-center justify-between">
            <div>
                <span class="text-xs font-black uppercase tracking-widest text-slate-400">SGNIA Real Estate • Nopalucan, Pue.</span>
                <h1 class="text-3xl font-extrabold text-white mt-1">
                    Publicar Nuevo Inmueble
                </h1>
                <p class="text-xs sm:text-sm text-slate-400">
                    Completa la información y selecciona la ubicación exacta en la vista satelital haciendo clic en el mapa.
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 hover:bg-slate-700 text-slate-300 font-bold text-xs rounded-xl transition">
                ← Volver al Panel
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-800/60 text-rose-300 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title & Type -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Título de la Propiedad *
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        required 
                        value="{{ old('title') }}" 
                        placeholder="Ej. Residencia Colonial frente a la Plaza Central"
                        class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium"
                    />
                </div>

                <div>
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Tipo de Inmueble *
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        required 
                        class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 text-white font-medium"
                    >
                        <option value="house" {{ old('type') == 'house' ? 'selected' : '' }}>Casa / Residencia</option>
                        <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Departamento / Ático</option>
                        <option value="commercial" {{ old('type') == 'commercial' ? 'selected' : '' }}>Local Comercial</option>
                    </select>
                </div>
            </div>

            <!-- Price & Address -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Precio ($ MXN) *
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="price" 
                        id="price" 
                        required 
                        value="{{ old('price') }}" 
                        placeholder="2500000"
                        class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 text-white font-medium"
                    />
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Dirección Completa *
                    </label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        required 
                        value="{{ old('address', 'Calle Constitución, Centro, 75120 Nopalucan de la Granja, Pue., México') }}" 
                        class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 text-white font-medium"
                    />
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Descripción Detallada *
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    required 
                    placeholder="Describe las habitaciones, acabados, servicios y características únicas..."
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 text-white font-medium"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Interactive Map Coordinate Picker -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold uppercase tracking-wider text-white">
                        📍 Ubicación Geográfica en Satélite (Haz clic para marcar)
                    </label>
                    <span class="text-[10px] font-bold text-slate-300 bg-slate-800 px-3 py-1 rounded-full border border-slate-700">
                        🛰️ Satélite HD (Esri)
                    </span>
                </div>
                
                <div id="picker-map" class="h-80 w-full rounded-2xl border border-slate-800 shadow-2xl z-0"></div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <label for="latitude" class="block text-xs font-bold text-slate-400">Latitud</label>
                        <input 
                            type="text" 
                            name="latitude" 
                            id="latitude" 
                            readonly 
                            required 
                            value="{{ old('latitude', '19.21620000') }}" 
                            class="w-full px-3 py-2 bg-slate-950 rounded-xl border border-slate-800 font-mono text-sm text-slate-200"
                        />
                    </div>
                    <div>
                        <label for="longitude" class="block text-xs font-bold text-slate-400">Longitud</label>
                        <input 
                            type="text" 
                            name="longitude" 
                            id="longitude" 
                            readonly 
                            required 
                            value="{{ old('longitude', '-97.82290000') }}" 
                            class="w-full px-3 py-2 bg-slate-950 rounded-xl border border-slate-800 font-mono text-sm text-slate-200"
                        />
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                    Fotografía del Inmueble (Opcional)
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-800 text-slate-300 font-medium bg-slate-950 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-slate-100 file:text-slate-950 hover:file:bg-white"
                />
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3.5 bg-slate-800 text-slate-300 font-bold text-sm rounded-xl border border-slate-700 hover:bg-slate-700 transition">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-8 py-3.5 bg-slate-100 hover:bg-white text-slate-950 font-extrabold rounded-xl shadow-md transition"
                >
                    Publicar Inmueble en SGNIA
                </button>
            </div>

        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const initialLat = parseFloat(latInput.value) || 19.216200;
        const initialLng = parseFloat(lngInput.value) || -97.822900;

        const pickerMap = L.map('picker-map', {
            scrollWheelZoom: false
        }).setView([initialLat, initialLng], 16);

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; Esri',
            maxZoom: 19
        });

        const streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        });

        satelliteLayer.addTo(pickerMap);

        const baseMaps = {
            "🛰️ Satélite HD": satelliteLayer,
            "🗺️ Vista Calle": streetLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(pickerMap);

        setTimeout(() => { pickerMap.invalidateSize(); }, 300);
        setTimeout(() => { pickerMap.invalidateSize(); }, 1000);

        let activeMarker = L.marker([initialLat, initialLng], { draggable: true }).addTo(pickerMap);
        activeMarker.bindPopup("Ubicación Seleccionada").openPopup();

        function updateCoords(lat, lng) {
            latInput.value = lat.toFixed(8);
            lngInput.value = lng.toFixed(8);
        }

        pickerMap.on('click', (e) => {
            const { lat, lng } = e.latlng;
            activeMarker.setLatLng([lat, lng]);
            updateCoords(lat, lng);
        });

        activeMarker.on('dragend', (e) => {
            const position = activeMarker.getLatLng();
            updateCoords(position.lat, position.lng);
        });
    });
</script>
@endsection
