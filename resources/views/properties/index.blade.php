@extends('layouts.app')

@section('title', 'Directorio de Propiedades - InmoGeoClima')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-800 to-slate-900 opacity-90"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-20"></div>
    
    <div class="max-w-7xl mx-auto relative z-10 space-y-4">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
            Fase 3: Frontend y Leaflet.js
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">
            Explora Inmuebles Geolocalizados
        </h1>
        <p class="text-lg text-slate-300 max-w-3xl">
            Haz clic en las tarjetas de propiedades para ubicarlas en el mapa interactivo en tiempo real y conocer las características de cada una.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- List of Properties (Left Column) -->
        <div class="lg:col-span-7 space-y-6">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center justify-between">
                <span>Propiedades Disponibles</span>
                <span class="text-sm font-medium text-slate-500">{{ $properties->count() }} inmuebles</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($properties as $property)
                    <div 
                        data-property-card
                        data-id="{{ $property->id }}"
                        data-lat="{{ $property->latitude }}"
                        data-lng="{{ $property->longitude }}"
                        class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 cursor-pointer overflow-hidden transition-all duration-300 flex flex-col group"
                        id="property-card-{{ $property->id }}"
                    >
                        <!-- Image Container -->
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($property->images->isNotEmpty())
                                <img 
                                    src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                    alt="{{ $property->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'"
                                />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col space-y-2">
                                <span class="px-3 py-1 text-xs font-extrabold uppercase rounded-lg shadow-sm border
                                    {{ $property->type === 'house' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                    {{ $property->type === 'apartment' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : '' }}
                                    {{ $property->type === 'commercial' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                                ">
                                    {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Apartamento' : 'Local') }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="font-bold text-slate-800 text-lg line-clamp-1 group-hover:text-indigo-600 transition">
                                    {{ $property->title }}
                                </h3>
                                <p class="text-slate-500 text-sm line-clamp-2">
                                    {{ $property->description }}
                                </p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center text-slate-400 text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $property->address }}</span>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                    <span class="text-2xl font-black text-indigo-600">
                                        ${{ number_format($property->price, 0, ',', '.') }}
                                    </span>
                                    <a 
                                        href="{{ route('properties.show', $property->id) }}" 
                                        class="px-4 py-2 text-sm font-bold text-indigo-600 hover:text-white hover:bg-indigo-600 border border-indigo-200 hover:border-indigo-600 rounded-xl transition duration-200"
                                    >
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-12 text-center text-slate-500 bg-white border border-dashed border-slate-200 rounded-2xl">
                        Aún no hay propiedades agregadas. Ejecuta el seeder para poblar datos de prueba.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Interactive Map (Right Column) -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 z-10">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-extrabold text-slate-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Ubicaciones en Tiempo Real
                        </h3>
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </div>
                    <!-- Leaflet map container -->
                    <div id="map" class="h-[600px] w-full bg-slate-50 z-0"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Initialize Map centered in Madrid (Default coordinates)
        const defaultLat = 40.416775;
        const defaultLng = -3.703790;
        const map = L.map('map', {
            scrollWheelZoom: false
        }).setView([defaultLat, defaultLng], 11);

        // 2. Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            maxZoom: 20
        }).addTo(map);

        // Store active markers by property ID
        const markers = {};

        // 3. Fetch properties from the API
        fetch("{{ route('api.properties.index') }}")
            .then(response => response.json())
            .then(properties => {
                if (properties.length === 0) return;

                const bounds = [];

                properties.forEach(property => {
                    const lat = parseFloat(property.latitude);
                    const lng = parseFloat(property.longitude);
                    bounds.push([lat, lng]);

                    // Custom styled popup content
                    let imageHtml = '';
                    if (property.images && property.images.length > 0) {
                        imageHtml = `<img src="/storage/${property.images[0].image_path}" class="w-full h-20 object-cover rounded-lg mb-2" onerror="this.style.display='none'" />`;
                    }

                    const popupContent = `
                        <div class="p-1 max-w-[200px]">
                            ${imageHtml}
                            <h4 class="font-bold text-slate-800 text-sm mb-1 leading-tight">${property.title}</h4>
                            <p class="text-indigo-600 font-extrabold text-sm mb-1">€${new Intl.NumberFormat('es-ES').format(property.price)}</p>
                            <a href="/properties/${property.id}" class="inline-flex justify-center items-center w-full px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                                Ver Ficha
                            </a>
                        </div>
                    `;

                    // Create Marker
                    const marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(popupContent);
                    
                    // Save marker in object
                    markers[property.id] = marker;
                });

                // Auto-fit map to fit all markers if multiple
                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }
            })
            .catch(error => console.error('Error fetching property coordinates:', error));

        // 4. Handle clicks on Property Cards to center the map
        const cards = document.querySelectorAll('[data-property-card]');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);

                // Highlight active card
                cards.forEach(c => c.classList.remove('ring-2', 'ring-indigo-500', 'border-transparent'));
                card.classList.add('ring-2', 'ring-indigo-500', 'border-transparent');

                // Smooth fly to location
                map.flyTo([lat, lng], 15, {
                    animate: true,
                    duration: 1.2
                });

                // Trigger popup open
                if (markers[id]) {
                    markers[id].openPopup();
                }
            });
        });
    });
</script>
@endsection
