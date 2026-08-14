@extends('layouts.app')

@section('title', 'Directorio Inmobiliario - SGNIA Real Estate')

@section('content')
<!-- Hero Section Cyber Dark -->
<div class="bg-[#0b0817] text-white py-14 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-[#ff2a85]/20">
    <div class="absolute inset-0 bg-gradient-to-r from-[#ff2a85]/10 via-purple-900/20 to-transparent"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-[#ff2a85]/20 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto relative z-10 space-y-4">
        <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest bg-[#ff2a85]/10 text-[#ff2a85] border border-[#ff2a85]/30">
            <span>SGNIA Real Estate • Nopalucan, Puebla</span>
        </div>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white">
            Explora Inmuebles con <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ff2a85] to-purple-400">Vista Satelital</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-300 max-w-3xl font-medium">
            Selecciona cualquier propiedad para interactuar con la vista aérea HD de alta resolución, ubicarla en tiempo real y conocer el clima actual de Nopalucan de la Granja.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- List of Properties (Left Column) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h2 class="text-2xl font-black text-white flex items-center">
                    <span>Propiedades Disponibles</span>
                </h2>
                <span class="px-3 py-1 bg-[#ff2a85]/20 text-[#ff2a85] font-extrabold text-xs rounded-full border border-[#ff2a85]/30">
                    {{ $properties->count() }} Inmuebles en Nopalucan
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($properties as $property)
                    <div 
                        data-property-card
                        data-id="{{ $property->id }}"
                        data-lat="{{ $property->latitude }}"
                        data-lng="{{ $property->longitude }}"
                        class="bg-[#110d22]/90 rounded-3xl border border-slate-800/80 hover:border-[#ff2a85] shadow-lg hover:shadow-neon cursor-pointer overflow-hidden transition-all duration-300 flex flex-col group backdrop-blur-md"
                        id="property-card-{{ $property->id }}"
                    >
                        <!-- Image Container -->
                        <div class="relative h-48 bg-slate-900 overflow-hidden">
                            @if($property->images->isNotEmpty())
                                <img 
                                    src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                    alt="{{ $property->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'"
                                />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-950 to-slate-900 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#ff2a85]/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col space-y-2">
                                <span class="px-3 py-1 text-xs font-black uppercase tracking-wider rounded-xl shadow-md backdrop-blur-md border
                                    {{ $property->type === 'house' ? 'bg-emerald-950/80 text-emerald-400 border-emerald-500/40' : '' }}
                                    {{ $property->type === 'apartment' ? 'bg-purple-950/80 text-purple-300 border-purple-500/40' : '' }}
                                    {{ $property->type === 'commercial' ? 'bg-rose-950/80 text-rose-400 border-rose-500/40' : '' }}
                                ">
                                    {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="font-bold text-white text-lg line-clamp-1 group-hover:text-[#ff2a85] transition">
                                    {{ $property->title }}
                                </h3>
                                <p class="text-slate-400 text-xs line-clamp-2 leading-relaxed">
                                    {{ $property->description }}
                                </p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center text-slate-400 text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-[#ff2a85] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $property->address }}</span>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-800/80">
                                    <span class="text-xl font-black text-[#ff2a85]">
                                        ${{ number_format($property->price, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">MXN</span>
                                    </span>
                                    <a 
                                        href="{{ route('properties.show', $property->id) }}" 
                                        class="px-3.5 py-1.5 text-xs font-extrabold text-white bg-[#ff2a85]/20 hover:bg-[#ff2a85] border border-[#ff2a85]/40 hover:border-[#ff2a85] rounded-xl transition duration-200"
                                    >
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-12 text-center text-slate-500 bg-[#110d22] border border-dashed border-slate-800 rounded-3xl">
                        Aún no hay propiedades agregadas en Nopalucan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Interactive Satellite Map (Right Column) -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 z-10">
                <div class="bg-[#110d22] rounded-3xl border border-slate-800/80 shadow-2xl overflow-hidden backdrop-blur-xl">
                    <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-[#0e0a1c]">
                        <h3 class="font-extrabold text-white text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#ff2a85]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2v1a2 2 0 002 2h2.945M8 3.935A9 9 0 1019.065 16" />
                            </svg>
                            Mapa Interactivo SGNIA
                        </h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-[#ff2a85]/20 text-[#ff2a85] border border-[#ff2a85]/30">
                                🛰️ Satélite HD
                            </span>
                        </div>
                    </div>
                    
                    <!-- Leaflet map container -->
                    <div id="map" class="h-[600px] w-full bg-[#07050e] z-0"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const defaultLat = 19.215050;
        const defaultLng = -97.817920;

        const map = L.map('map', {
            scrollWheelZoom: false
        }).setView([defaultLat, defaultLng], 15);

        // 1. High Resolution Esri Satellite Layer
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 19
        });

        // 2. OpenStreetMap Street Layer
        const streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        });

        // Add Satellite as Default
        satelliteLayer.addTo(map);

        // Layer Control (Allows switching between Satellite HD & Street View)
        const baseMaps = {
            "🛰️ Satélite HD (Esri)": satelliteLayer,
            "🗺️ Vista Calle (OSM)": streetLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

        // Invalidate size to guarantee sharp rendering
        setTimeout(() => { map.invalidateSize(); }, 300);
        setTimeout(() => { map.invalidateSize(); }, 1000);

        const markers = {};

        // Fetch properties from the API
        fetch("{{ route('api.properties.index') }}")
            .then(response => response.json())
            .then(properties => {
                if (properties.length === 0) return;

                const bounds = [];

                properties.forEach(property => {
                    const lat = parseFloat(property.latitude);
                    const lng = parseFloat(property.longitude);
                    bounds.push([lat, lng]);

                    let imageHtml = '';
                    if (property.images && property.images.length > 0) {
                        imageHtml = `<img src="/storage/${property.images[0].image_path}" class="w-full h-24 object-cover rounded-xl mb-2" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'" />`;
                    }

                    const popupContent = `
                        <div class="p-1 max-w-[210px] text-white">
                            ${imageHtml}
                            <h4 class="font-bold text-white text-sm mb-1 leading-tight">${property.title}</h4>
                            <p class="text-[#ff2a85] font-black text-sm mb-2">$${new Intl.NumberFormat('es-MX').format(property.price)} MXN</p>
                            <a href="/properties/${property.id}" class="inline-flex justify-center items-center w-full px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-[#ff2a85] to-purple-600 rounded-lg shadow-md transition hover:opacity-90">
                                Ver Ficha
                            </a>
                        </div>
                    `;

                    const marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(popupContent);
                    markers[property.id] = marker;
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }
            })
            .catch(error => console.error('Error fetching property coordinates:', error));

        // Click on Property Card to Fly to location
        const cards = document.querySelectorAll('[data-property-card]');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);

                cards.forEach(c => c.classList.remove('ring-2', 'ring-[#ff2a85]', 'border-transparent'));
                card.classList.add('ring-2', 'ring-[#ff2a85]', 'border-transparent');

                map.flyTo([lat, lng], 17, {
                    animate: true,
                    duration: 1.2
                });

                if (markers[id]) {
                    markers[id].openPopup();
                }
            });
        });
    });
</script>
@endsection
