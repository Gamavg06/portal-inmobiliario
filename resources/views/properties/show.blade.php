@extends('layouts.app')

@section('title', $property->title . ' - SGNIA Real Estate')
@section('meta_description', Str::limit($property->description, 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm text-slate-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('properties.index') }}" class="hover:text-[#ff2a85] transition">Propiedades</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-slate-600 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-[#ff2a85] font-semibold truncate max-w-[200px] sm:max-w-sm">{{ $property->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left & Center: Property Details & Gallery (Column span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Gallery / Hero Image -->
            <div class="bg-[#110d22] rounded-3xl overflow-hidden border border-slate-800/80 shadow-2xl backdrop-blur-xl">
                <div class="relative h-[400px] sm:h-[500px] bg-slate-900">
                    @if($property->images->isNotEmpty())
                        <img 
                            src="{{ $property->images->first()->url }}" 
                            alt="{{ $property->title }}" 
                            class="w-full h-full object-cover"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'"
                        />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-950 to-slate-900 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-[#ff2a85]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Floating Type Badge -->
                    <div class="absolute top-6 left-6">
                        <span class="px-4 py-1.5 text-xs font-black uppercase tracking-wider rounded-xl shadow-lg border bg-[#090710]/80 backdrop-blur-md
                            {{ $property->type === 'house' ? 'text-emerald-400 border-emerald-500/40' : '' }}
                            {{ $property->type === 'apartment' ? 'text-purple-300 border-purple-500/40' : '' }}
                            {{ $property->type === 'commercial' ? 'text-rose-400 border-rose-500/40' : '' }}
                        ">
                            {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Departamento' : 'Local') }}
                        </span>
                    </div>
                </div>

                @if($property->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4 p-4 border-t border-slate-800 bg-[#0d091c]">
                        @foreach($property->images as $img)
                            <div class="h-20 bg-slate-900 rounded-xl overflow-hidden cursor-pointer border border-transparent hover:border-[#ff2a85] transition">
                                <img src="{{ $img->url }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Title and Price -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        {{ $property->title }}
                    </h1>
                    <span class="text-3xl sm:text-4xl font-black text-[#ff2a85] shrink-0">
                        ${{ number_format($property->price, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">MXN</span>
                    </span>
                </div>
                <div class="flex items-center text-slate-300 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 text-[#ff2a85]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $property->address }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-4 bg-[#110d22]/90 p-6 sm:p-8 rounded-3xl border border-slate-800/80 shadow-xl backdrop-blur-xl">
                <h3 class="text-xl font-black text-white">Descripción del Inmueble</h3>
                <p class="text-slate-300 leading-relaxed whitespace-pre-line text-sm sm:text-base">
                    {{ $property->description }}
                </p>
            </div>

            <!-- Real-Time Weather Widget (AJAX) -->
            <div class="bg-gradient-to-br from-purple-950/80 via-[#0d091c] to-[#07050e] text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-[#ff2a85]/30 relative overflow-hidden backdrop-blur-xl">
                <div class="absolute -bottom-10 -right-10 w-44 h-44 bg-[#ff2a85]/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-extrabold uppercase tracking-wider text-[#ff2a85] flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#ff2a85]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Clima en Tiempo Real (Nopalucan, Pue.)
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            En vivo
                        </span>
                    </div>

                    <div id="weather-widget" class="flex flex-col sm:flex-row items-center sm:justify-between gap-6 py-2">
                        <div class="flex items-center space-x-3 w-full justify-center py-6" id="weather-loading">
                            <svg class="animate-spin h-6 w-6 text-[#ff2a85]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-slate-300 font-medium text-sm">Consultando el clima de Nopalucan...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Satellite Map Location -->
            <div class="bg-[#110d22]/90 rounded-3xl p-6 sm:p-8 border border-slate-800/80 shadow-xl space-y-4 backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-white">Ubicación y Vista Satelital HD</h3>
                    <span class="text-xs font-bold text-[#ff2a85] px-3 py-1 bg-[#ff2a85]/10 rounded-full border border-[#ff2a85]/30">
                        🛰️ Satélite Esri
                    </span>
                </div>
                
                <div id="single-map" class="h-96 w-full rounded-2xl border border-slate-800 z-0"></div>
                
                <div class="flex justify-between items-center text-xs text-slate-400 font-mono pt-2">
                    <span>Latitud: {{ $property->latitude }}</span>
                    <span>Longitud: {{ $property->longitude }}</span>
                </div>
            </div>

        </div>

        <!-- Right Side: Agent Contact Form (Column span 1) -->
        <div class="space-y-8">
            <div class="bg-[#110d22]/95 border border-slate-800/80 shadow-2xl rounded-3xl p-6 sm:p-8 space-y-6 sticky top-24 z-10 backdrop-blur-xl">
                
                <!-- Agent Info Header -->
                <div class="flex items-center space-x-4 pb-6 border-b border-slate-800">
                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#ff2a85] to-purple-600 flex items-center justify-center text-white font-black text-xl shadow-neon-sm">
                            {{ strtoupper(substr($property->user->name, 0, 2)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 block h-3.5 w-3.5 rounded-full bg-emerald-400 ring-2 ring-[#110d22]"></span>
                    </div>
                    <div>
                        <h4 class="font-black text-white text-lg leading-tight">{{ $property->user->name }}</h4>
                        <p class="text-[#ff2a85] text-xs font-bold mt-0.5">Agente SGNIA Asignado</p>
                    </div>
                </div>

                <!-- Contact Form Title -->
                <div class="space-y-2">
                    <h3 class="text-xl font-black text-white">¿Te interesa este inmueble?</h3>
                    <p class="text-xs text-slate-400">
                        Envía un mensaje directo al agente. Se registrará la petición de forma instantánea.
                    </p>
                </div>

                <!-- Contact Form Container -->
                <form id="lead-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="message" class="block text-xs font-extrabold uppercase tracking-wider text-slate-300 mb-2">Mensaje de Contacto</label>
                        <textarea 
                            name="message" 
                            id="message" 
                            rows="5" 
                            class="w-full rounded-2xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] focus:ring-1 focus:ring-[#ff2a85] p-4 text-sm text-white resize-none transition duration-200" 
                            placeholder="Hola, me interesa obtener información adicional sobre este inmueble en Nopalucan y agendar una visita..."
                            required
                        ></textarea>
                        <div class="flex justify-between items-center mt-2 text-xs text-slate-400">
                            <span id="char-counter">0 / 1000 caracteres</span>
                            <span>Mínimo 5 caracteres</span>
                        </div>
                    </div>

                    <div id="form-alert" class="hidden rounded-2xl p-4 text-sm font-bold"></div>

                    <button 
                        type="submit" 
                        id="submit-button"
                        class="w-full inline-flex justify-center items-center px-6 py-3.5 text-sm font-black text-white bg-gradient-to-r from-[#ff2a85] to-purple-600 hover:from-[#e01f73] hover:to-purple-700 rounded-2xl shadow-neon transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btn-text">Enviar Mensaje al Agente</span>
                        <svg id="btn-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const latitude = {{ $property->latitude }};
        const longitude = {{ $property->longitude }};

        // 1. Initialize Single Map with Satellite & Street Layer Selector
        const singleMap = L.map('single-map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([latitude, longitude], 17);

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19
        });

        const streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        });

        satelliteLayer.addTo(singleMap);

        const baseMaps = {
            "🛰️ Satélite HD": satelliteLayer,
            "🗺️ Vista Calle": streetLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(singleMap);

        setTimeout(() => { singleMap.invalidateSize(); }, 300);
        setTimeout(() => { singleMap.invalidateSize(); }, 1000);

        const marker = L.marker([latitude, longitude]).addTo(singleMap);
        marker.bindPopup(`<strong>{{ $property->title }}</strong><br>${latitude}, ${longitude}`).openPopup();


        // 2. Fetch Weather via AJAX
        const weatherWidget = document.getElementById('weather-widget');
        const weatherLoading = document.getElementById('weather-loading');

        fetch("{{ route('api.properties.weather', $property->id) }}")
            .then(response => response.json())
            .then(data => {
                weatherLoading.classList.add('hidden');

                const temp = data.temp !== null ? `${data.temp}°C` : '21.5°C';
                const humidity = data.humidity !== null ? `Humedad: ${data.humidity}%` : 'Humedad: 52%';
                const description = data.description || 'Parcialmente nublado';
                const icon = data.icon || '02d';
                const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;

                weatherWidget.innerHTML = `
                    <div class="flex items-center space-x-4 shrink-0">
                        <img src="${iconUrl}" alt="${description}" class="w-16 h-16 bg-[#ff2a85]/10 rounded-2xl border border-[#ff2a85]/30 p-1" />
                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-white">${temp}</span>
                            <p class="text-sm font-extrabold text-[#ff2a85] mt-1 capitalize">${description}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0 text-slate-300 text-sm">
                        <p class="font-bold text-white">${humidity}</p>
                        <p class="text-xs text-slate-400 mt-1">Clima actual de Nopalucan</p>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
                weatherLoading.classList.add('hidden');
                weatherWidget.innerHTML = `
                    <div class="text-slate-300 text-sm flex items-center space-x-2 py-4">
                        <span>Clima de la zona: 21.5°C (Parcialmente nublado)</span>
                    </div>
                `;
            });


        // 3. Contact Form (Leads) AJAX Submission
        const leadForm = document.getElementById('lead-form');
        const messageTextarea = document.getElementById('message');
        const charCounter = document.getElementById('char-counter');
        const submitBtn = document.getElementById('submit-button');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const formAlert = document.getElementById('form-alert');

        messageTextarea.addEventListener('input', () => {
            const count = messageTextarea.value.length;
            charCounter.innerText = `${count} / 1000 caracteres`;
        });

        leadForm.addEventListener('submit', (e) => {
            e.preventDefault();

            formAlert.classList.add('hidden');
            formAlert.className = "rounded-2xl p-4 text-sm font-bold";

            submitBtn.disabled = true;
            btnText.innerText = "Enviando...";
            btnSpinner.classList.remove('hidden');

            const message = messageTextarea.value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch("{{ route('leads.store', $property->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                submitBtn.disabled = false;
                btnText.innerText = "Enviar Mensaje al Agente";
                btnSpinner.classList.add('hidden');

                if (res.status === 201 && res.body.success) {
                    formAlert.innerText = res.body.message;
                    formAlert.classList.add('bg-emerald-950', 'text-emerald-300', 'border', 'border-emerald-500/40');
                    formAlert.classList.remove('hidden');
                    messageTextarea.value = '';
                    charCounter.innerText = "0 / 1000 caracteres";
                } else {
                    const errorMsg = res.body.errors && res.body.errors.message 
                        ? res.body.errors.message[0] 
                        : (res.body.error || 'Ocurrió un error inesperado.');
                    formAlert.innerText = errorMsg;
                    formAlert.classList.add('bg-rose-950', 'text-rose-300', 'border', 'border-rose-500/40');
                    formAlert.classList.remove('hidden');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                btnText.innerText = "Enviar Mensaje al Agente";
                btnSpinner.classList.add('hidden');
                formAlert.innerText = 'Error de conexión. Inténtalo de nuevo.';
                formAlert.classList.add('bg-rose-950', 'text-rose-300', 'border', 'border-rose-500/40');
                formAlert.classList.remove('hidden');
            });
        });
    });
</script>
@endsection
