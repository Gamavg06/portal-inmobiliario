@extends('layouts.app')

@section('title', $property->title . ' - InmoGeoClima')
@section('meta_description', Str::limit($property->description, 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('properties.index') }}" class="hover:text-indigo-600 transition">Propiedades</a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-slate-400 font-medium truncate max-w-[200px] sm:max-w-sm">{{ $property->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left & Center: Property Details & Gallery (Column span 2) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Gallery / Hero Image -->
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                <div class="relative h-[400px] sm:h-[500px] bg-slate-100">
                    @if($property->images->isNotEmpty())
                        <img 
                            src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                            alt="{{ $property->title }}" 
                            class="w-full h-full object-cover"
                            onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'"
                        />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Floating Type Badge -->
                    <div class="absolute top-6 left-6">
                        <span class="px-4 py-1.5 text-xs font-black uppercase tracking-wider rounded-xl shadow-lg border bg-white/90 backdrop-blur-md
                            {{ $property->type === 'house' ? 'text-emerald-700 border-emerald-200' : '' }}
                            {{ $property->type === 'apartment' ? 'text-indigo-700 border-indigo-200' : '' }}
                            {{ $property->type === 'commercial' ? 'text-rose-700 border-rose-200' : '' }}
                        ">
                            {{ $property->type === 'house' ? 'Casa' : ($property->type === 'apartment' ? 'Apartamento' : 'Local') }}
                        </span>
                    </div>
                </div>

                <!-- Secondary Images Grid if any -->
                @if($property->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4 p-4 border-t border-slate-100 bg-slate-50/50">
                        @foreach($property->images as $img)
                            <div class="h-20 bg-slate-100 rounded-xl overflow-hidden cursor-pointer hover:ring-2 hover:ring-indigo-500 transition">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Title and Price -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        {{ $property->title }}
                    </h1>
                    <span class="text-3xl sm:text-4xl font-black text-indigo-600 shrink-0">
                        ${{ number_format($property->price, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex items-center text-slate-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $property->address }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-bold text-slate-950">Descripción</h3>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $property->description }}
                </p>
            </div>

            <!-- Real-Time Weather Widget (AJAX) -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
                <!-- Abstract weather shapes background -->
                <div class="absolute -bottom-10 -right-10 w-44 h-44 bg-indigo-500/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold uppercase tracking-wider text-indigo-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Clima en Tiempo Real
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            En vivo
                        </span>
                    </div>

                    <!-- Weather Loading / Content State -->
                    <div id="weather-widget" class="flex flex-col sm:flex-row items-center sm:justify-between gap-6 py-2">
                        <!-- Loading State (default HTML) -->
                        <div class="flex items-center space-x-3 w-full justify-center py-6" id="weather-loading">
                            <svg class="animate-spin h-6 w-6 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-slate-300 font-medium">Consultando el clima de la ubicación...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Location -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xl font-bold text-slate-950">Ubicación del Inmueble</h3>
                <div id="single-map" class="h-80 w-full rounded-2xl border border-slate-100 z-0"></div>
                <div class="flex justify-between items-center text-xs text-slate-400">
                    <span>Latitud: {{ $property->latitude }}</span>
                    <span>Longitud: {{ $property->longitude }}</span>
                </div>
            </div>

        </div>

        <!-- Right Side: Agent Contact Form (Column span 1) -->
        <div class="space-y-8">
            
            <!-- Agent Card & Contact Form -->
            <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-8 space-y-6 sticky top-24 z-10">
                
                <!-- Agent Info Header -->
                <div class="flex items-center space-x-4 pb-6 border-b border-slate-100">
                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-50 border-2 border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xl">
                            {{ strtoupper(substr($property->user->name, 0, 2)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 block h-3.5 w-3.5 rounded-full bg-emerald-400 ring-2 ring-white"></span>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg leading-tight">{{ $property->user->name }}</h4>
                        <p class="text-slate-400 text-xs mt-0.5">Agente Asignado</p>
                    </div>
                </div>

                <!-- Contact Form Title -->
                <div class="space-y-2">
                    <h3 class="text-xl font-extrabold text-slate-900">¿Te interesa este inmueble?</h3>
                    <p class="text-xs text-slate-400">
                        Envía un mensaje directo al agente. Se registrará la petición de forma instantánea.
                    </p>
                </div>

                <!-- Contact Form Container -->
                <form id="lead-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Mensaje de Contacto</label>
                        <textarea 
                            name="message" 
                            id="message" 
                            rows="5" 
                            class="w-full rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 p-4 text-sm resize-none transition duration-200" 
                            placeholder="Hola, me interesa obtener información adicional sobre este inmueble y agendar una visita..."
                            required
                        ></textarea>
                        <div class="flex justify-between items-center mt-2 text-xs text-slate-400">
                            <span id="char-counter">0 / 1000 caracteres</span>
                            <span>Mínimo 5 caracteres</span>
                        </div>
                    </div>

                    <!-- Alert message container -->
                    <div id="form-alert" class="hidden rounded-2xl p-4 text-sm"></div>

                    <!-- Test user context notice -->
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-2xl flex items-start space-x-2 text-amber-700 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>
                            <strong>Nota de pruebas:</strong> Al enviar el formulario, si no has iniciado sesión, se registrará bajo el usuario comprador <strong>Lucía Gómez</strong> (creado por el Seeder).
                        </span>
                    </div>

                    <button 
                        type="submit" 
                        id="submit-button"
                        class="w-full inline-flex justify-center items-center px-6 py-3.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-2xl shadow-lg shadow-indigo-100 hover:shadow-indigo-200 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btn-text">Enviar Mensaje</span>
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

        // ==========================================
        // 1. Initialize Single Location Map (Leaflet)
        // ==========================================
        const singleMap = L.map('single-map', {
            scrollWheelZoom: false,
            zoomControl: true
        }).setView([latitude, longitude], 15);

        L.tileLayer('https://{s}.tile.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            maxZoom: 20
        }).addTo(singleMap);

        // Add Marker
        const marker = L.marker([latitude, longitude]).addTo(singleMap);
        marker.bindPopup(`<strong>{{ $property->title }}</strong><br>${latitude}, ${longitude}`).openPopup();


        // ==========================================
        // 2. Fetch Weather via AJAX (OpenWeatherMap)
        // ==========================================
        const weatherWidget = document.getElementById('weather-widget');
        const weatherLoading = document.getElementById('weather-loading');

        fetch("{{ route('api.properties.weather', $property->id) }}")
            .then(response => response.json())
            .then(data => {
                // Remove loading
                weatherLoading.classList.add('hidden');

                if (data.error) {
                    weatherWidget.innerHTML = `
                        <div class="flex items-center space-x-2 text-rose-300 text-sm py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span><strong>No se pudo cargar el clima:</strong> ${data.description} (${data.error}). Por favor, verifica que la OPENWEATHER_API_KEY esté correctamente configurada en el archivo .env.</span>
                        </div>
                    `;
                    return;
                }

                // Render dynamic weather details
                const temp = data.temp !== null ? `${data.temp}°C` : 'N/D';
                const humidity = data.humidity !== null ? `Humedad: ${data.humidity}%` : '';
                const description = data.description || 'Desconocido';
                const icon = data.icon;
                const iconUrl = icon ? `https://openweathermap.org/img/wn/${icon}@2x.png` : null;

                weatherWidget.innerHTML = `
                    <div class="flex items-center space-x-4 shrink-0">
                        ${iconUrl ? `<img src="${iconUrl}" alt="${description}" class="w-16 h-16 bg-white/10 rounded-2xl" />` : ''}
                        <div>
                            <span class="text-4xl sm:text-5xl font-black">${temp}</span>
                            <p class="text-sm font-semibold text-indigo-300 mt-1 capitalize">${description}</p>
                        </div>
                    </div>
                    <div class="text-right sm:text-right shrink-0 text-slate-300 text-sm">
                        <p class="font-medium">${humidity}</p>
                        <p class="text-xs text-slate-400 mt-1">Clima actual de la zona</p>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
                weatherLoading.classList.add('hidden');
                weatherWidget.innerHTML = `
                    <div class="text-rose-300 text-sm flex items-center space-x-2 py-4">
                        <span>Ocurrió un error al obtener la respuesta del clima.</span>
                    </div>
                `;
            });


        // ==========================================
        // 3. Contact Form (Leads) AJAX Submission
        // ==========================================
        const leadForm = document.getElementById('lead-form');
        const messageTextarea = document.getElementById('message');
        const charCounter = document.getElementById('char-counter');
        const submitBtn = document.getElementById('submit-button');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const formAlert = document.getElementById('form-alert');

        // Character counter
        messageTextarea.addEventListener('input', () => {
            const count = messageTextarea.value.length;
            charCounter.innerText = `${count} / 1000 caracteres`;
            if (count > 1000) {
                charCounter.classList.add('text-rose-500');
            } else {
                charCounter.classList.remove('text-rose-500');
            }
        });

        // Submit form
        leadForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear alert states
            formAlert.classList.add('hidden');
            formAlert.className = "rounded-2xl p-4 text-sm";

            // Loading state
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
                // Reset loading button
                submitBtn.disabled = false;
                btnText.innerText = "Enviar Mensaje";
                btnSpinner.classList.add('hidden');

                if (res.status === 201 && res.body.success) {
                    // Success alert
                    formAlert.innerText = res.body.message;
                    formAlert.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
                    formAlert.classList.remove('hidden');

                    // Reset text fields
                    messageTextarea.value = '';
                    charCounter.innerText = "0 / 1000 caracteres";
                } else {
                    // Error alerts
                    const errorMsg = res.body.errors && res.body.errors.message 
                        ? res.body.errors.message[0] 
                        : (res.body.error || 'Ocurrió un error inesperado.');
                    formAlert.innerText = errorMsg;
                    formAlert.classList.add('bg-rose-50', 'text-rose-800', 'border', 'border-rose-200');
                    formAlert.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error submitting lead message:', error);
                submitBtn.disabled = false;
                btnText.innerText = "Enviar Mensaje";
                btnSpinner.classList.add('hidden');

                formAlert.innerText = 'Error de conexión. Inténtalo de nuevo más tarde.';
                formAlert.classList.add('bg-rose-50', 'text-rose-800', 'border', 'border-rose-200');
                formAlert.classList.remove('hidden');
            });
        });
    });
</script>
@endsection
