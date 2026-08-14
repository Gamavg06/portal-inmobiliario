@extends('layouts.app')

@section('title', 'Explorar Inmuebles Satelitales - SGNIA Real Estate')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-b from-slate-900 via-[#131927] to-[#0b0f19] border-b border-slate-800/80 overflow-hidden py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-slate-800 text-slate-200 border border-slate-700 shadow-sm">
                🛰️ Ubicación Satelital HD • Nopalucan, Puebla
            </span>
            
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Encuentra tu Inmueble Ideal en <span class="text-slate-300 underline decoration-slate-600 decoration-2">SGNIA.</span>
            </h1>
            
            <p class="text-base sm:text-lg text-slate-400 font-medium max-w-2xl mx-auto leading-relaxed">
                Explora residencias, terrenos y locales comerciales con vista satelital interactiva y datos del clima en tiempo real.
            </p>
        </div>
    </div>
</div>

<!-- Main Section: Properties Grid & Satellite Map -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

    <!-- Interactive Esri Satellite Map Container -->
    <div class="bg-slate-900/90 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-2xl space-y-4 backdrop-blur-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Mapa Satelital en Tiempo Real (Nopalucan de la Granja)
                </h2>
                <p class="text-xs text-slate-400">Selecciona cualquier marcador o cambia a la vista de calle para explorar el área</p>
            </div>
            
            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700">
                🛰️ Satélite Esri HD Activo
            </span>
        </div>

        <div id="properties-map" class="h-[450px] w-full rounded-2xl border border-slate-800 shadow-inner z-0"></div>
    </div>

    <!-- Properties List Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-800 pb-4 gap-4">
        <div>
            <h3 class="text-2xl font-extrabold text-white">Catálogo de Propiedades</h3>
            <p class="text-xs text-slate-400">Mostrando {{ $properties->count() }} inmuebles disponibles</p>
        </div>

        <div class="flex items-center space-x-2 text-xs font-bold text-slate-400">
            <span>Filtrar por:</span>
            <span class="px-3 py-1 bg-slate-800 text-white rounded-lg border border-slate-700">Todos</span>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($properties as $property)
            <div class="group bg-slate-900/90 rounded-3xl border border-slate-800 hover:border-slate-600 shadow-xl hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col backdrop-blur-xl">
                
                <!-- Image Container -->
                <div class="relative h-52 bg-slate-950 overflow-hidden">
                    @if($property->images->isNotEmpty())
                        <img 
                            src="{{ $property->images->first()->url }}" 
                            alt="{{ $property->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'"
                        />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-900 to-slate-950 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif

                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg shadow-md border bg-slate-950/90 text-slate-200 border-slate-700">
                            {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 right-4">
                        <span class="px-3 py-1 bg-slate-950/90 text-white font-extrabold text-sm rounded-lg border border-slate-800 shadow-md">
                            ${{ number_format($property->price, 0, ',', '.') }} MXN
                        </span>
                    </div>
                </div>

                <!-- Details Content -->
                <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                    <div>
                        <h4 class="text-lg font-extrabold text-white group-hover:text-slate-300 transition duration-200 line-clamp-2 leading-snug">
                            {{ $property->title }}
                        </h4>
                        <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                            {{ $property->description }}
                        </p>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-slate-800/80">
                        <div class="flex items-center text-xs text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="line-clamp-1 text-slate-300 font-semibold">{{ $property->address }}</span>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button 
                                type="button" 
                                onclick="focusOnProperty({{ $property->latitude }}, {{ $property->longitude }}, '{{ addslashes($property->title) }}')"
                                class="text-xs font-bold text-slate-300 hover:text-white flex items-center transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ubicar en Mapa
                            </button>

                            <a 
                                href="{{ route('properties.show', $property->id) }}" 
                                class="inline-flex items-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl border border-slate-700 transition"
                            >
                                Ver Ficha →
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-slate-900/60 rounded-3xl border border-slate-800">
                <p class="text-slate-400 font-medium">No se encontraron propiedades registradas en este momento.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

@section('scripts')
<script>
    let map;
    let markers = [];

    document.addEventListener('DOMContentLoaded', () => {
        // Nopalucan de la Granja Center Coordinates
        const defaultLat = 19.215050;
        const defaultLng = -97.817920;

        // Initialize Map
        map = L.map('properties-map', {
            scrollWheelZoom: false
        }).setView([defaultLat, defaultLng], 14);

        // Satellite Tile Layer (Esri World Imagery)
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 19
        });

        // Street View Tile Layer (OpenStreetMap)
        const streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        });

        // Default set Satellite
        satelliteLayer.addTo(map);

        // Layer Control
        const baseMaps = {
            "🛰️ Satélite HD (Esri)": satelliteLayer,
            "🗺️ Vista Calle (OSM)": streetLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

        // Fix Leaflet tile loading inside Cloud9 container
        setTimeout(() => { map.invalidateSize(); }, 300);
        setTimeout(() => { map.invalidateSize(); }, 1000);

        // Load Properties via Fetch API
        fetch("{{ route('api.properties.index') }}")
            .then(response => response.json())
            .then(properties => {
                properties.forEach(property => {
                    if (property.latitude && property.longitude) {
                        let imageHtml = '';
                        if (property.images && property.images.length > 0) {
                            const rawPath = property.images[0].image_path;
                            const fullUrl = (rawPath.startsWith('http://') || rawPath.startsWith('https://')) ? rawPath : `/storage/${rawPath}`;
                            imageHtml = `<img src="${fullUrl}" class="w-full h-24 object-cover rounded-xl mb-2" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'" />`;
                        }

                        const popupContent = `
                            <div class="p-1 max-w-xs">
                                ${imageHtml}
                                <h4 class="font-extrabold text-sm text-white leading-tight mb-1">${property.title}</h4>
                                <p class="text-xs text-slate-300 font-bold mb-2">$${Number(property.price).toLocaleString('es-MX')} MXN</p>
                                <a href="/properties/${property.id}" class="inline-block w-full text-center px-3 py-1.5 bg-slate-100 hover:bg-white text-slate-950 font-black text-xs rounded-lg transition">
                                    Ver Detalles Completo
                                </a>
                            </div>
                        `;

                        const marker = L.marker([property.latitude, property.longitude])
                            .addTo(map)
                            .bindPopup(popupContent);

                        markers.push({
                            id: property.id,
                            marker: marker,
                            lat: property.latitude,
                            lng: property.longitude
                        });
                    }
                });
            })
            .catch(err => console.error('Error cargando marcas de mapa:', err));
    });

    function focusOnProperty(lat, lng, title) {
        if (map) {
            map.flyTo([lat, lng], 17, { duration: 1.5 });
            const found = markers.find(m => m.lat === lat && m.lng === lng);
            if (found) {
                setTimeout(() => { found.marker.openPopup(); }, 1500);
            }
            window.scrollTo({ top: document.getElementById('properties-map').offsetTop - 100, behavior: 'smooth' });
        }
    }
</script>
@endsection
