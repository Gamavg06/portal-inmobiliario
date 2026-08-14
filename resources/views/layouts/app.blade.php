<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#07050e]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SGNIA Real Estate - Inmuebles Geolocalizados')</title>
    <meta name="description" content="@yield('meta_description', 'SGNIA Real Estate - Explora inmuebles geolocalizados con vista satelital y clima en tiempo real en Nopalucan de la Granja, Puebla.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet.js (Mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            background-color: #07050e;
            color: #f1f5f9;
        }
        h1, h2, h3, h4, .brand-font {
            font-family: 'Syne', sans-serif;
        }

        /* Subtle UX/UI Designer Grid Pattern */
        .bg-grid-pattern {
            background-size: 50px 50px;
            background-image: 
                linear-gradient(to right, rgba(255, 42, 133, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 42, 133, 0.04) 1px, transparent 1px);
        }

        /* Neon Accent Utilities */
        .text-magenta { color: #ff2a85; }
        .bg-magenta { background-color: #ff2a85; }
        .border-magenta { border-color: #ff2a85; }
        
        .shadow-neon {
            box-shadow: 0 0 25px rgba(255, 42, 133, 0.4);
        }
        .shadow-neon-sm {
            box-shadow: 0 0 12px rgba(255, 42, 133, 0.3);
        }

        /* Leaflet Popups Cyber Dark Styling */
        .leaflet-popup-content-wrapper, .leaflet-popup-tip {
            background: #130e24 !important;
            color: #f1f5f9 !important;
            border: 1px solid rgba(255, 42, 133, 0.3) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7) !important;
            border-radius: 1rem !important;
        }
    </style>
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-200 bg-[#07050e] bg-grid-pattern relative selection:bg-[#ff2a85] selection:text-white">

    <!-- Interactive Mouse Cursor Spotlight (Difuminado Neón) -->
    <div id="cursor-spotlight" class="pointer-events-none fixed inset-0 z-30 transition-opacity duration-300"></div>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-[#07050e]/80 backdrop-blur-xl border-b border-[#ff2a85]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Brand Logo SGNIA -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('properties.index') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#ff2a85] to-purple-600 flex items-center justify-center text-white shadow-neon group-hover:scale-105 transition duration-300">
                            <span class="brand-font font-black text-xl tracking-tighter">S</span>
                        </div>
                        <div>
                            <span class="brand-font text-2xl font-black tracking-tight text-white group-hover:text-[#ff2a85] transition duration-200">
                                SGNIA<span class="text-[#ff2a85]">.</span>
                            </span>
                            <span class="block text-[10px] font-extrabold uppercase tracking-widest text-[#ff2a85]/80 -mt-1">Real Estate</span>
                        </div>
                    </a>
                </div>

                <!-- Nav Links -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('properties.index') }}" class="text-sm font-bold tracking-wide {{ request()->routeIs('properties.index') ? 'text-[#ff2a85] border-b-2 border-[#ff2a85]' : 'text-slate-400 hover:text-white' }} py-2 transition duration-200">
                        Propiedades
                    </a>
                    <a href="#" class="text-sm font-bold tracking-wide text-slate-400 hover:text-white py-2 transition duration-200">Agentes</a>
                    <a href="#" class="text-sm font-bold tracking-wide text-slate-400 hover:text-white py-2 transition duration-200">Sobre Nosotros</a>
                </nav>

                <!-- Auth / Admin Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                        @if(in_array(Auth::user()->role, ['admin', 'agent']))
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-[#ff2a85] bg-[#ff2a85]/10 border border-[#ff2a85]/40 rounded-xl hover:bg-[#ff2a85] hover:text-white transition duration-200 shadow-neon-sm">
                                👑 Panel Admin
                            </a>
                            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-[#ff2a85] to-purple-600 rounded-xl shadow-neon hover:opacity-90 transition duration-200">
                                + Publicar
                            </a>
                        @endif

                        <div class="flex items-center space-x-3 border-l border-slate-800 pl-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-extrabold text-white leading-none">{{ Auth::user()->name }}</p>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#ff2a85]">
                                    {{ Auth::user()->role === 'admin' ? 'Admin' : (Auth::user()->role === 'agent' ? 'Agente' : 'Comprador') }}
                                </span>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3.5 py-1.5 text-xs font-bold text-rose-400 hover:text-white hover:bg-rose-600/80 border border-rose-500/30 rounded-xl transition duration-200">
                                    Salir
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-slate-300 hover:text-white border border-slate-800 hover:border-[#ff2a85]/40 rounded-xl transition duration-200">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-[#ff2a85] to-purple-600 hover:from-[#e01f73] hover:to-purple-700 rounded-xl shadow-neon transition duration-200">
                            Registrarse
                        </a>
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow relative z-10">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 text-sm font-bold flex items-center justify-between shadow-lg shadow-emerald-950/50 backdrop-blur-md">
                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-sm font-bold flex items-center space-x-3 shadow-lg shadow-rose-950/50 backdrop-blur-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#040309] text-slate-400 border-t border-[#ff2a85]/20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-[#ff2a85] to-purple-600 flex items-center justify-center text-white shadow-neon-sm">
                            <span class="brand-font font-black text-sm">S</span>
                        </div>
                        <span class="brand-font text-xl font-black text-white tracking-tight">SGNIA<span class="text-[#ff2a85]">.</span></span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-sm">
                        Plataforma inmobiliaria de diseño digital con mapas interactivos satelitales en tiempo real y análisis climático para Nopalucan de la Granja, Puebla.
                    </p>
                </div>
                <div>
                    <h3 class="text-xs font-extrabold text-white uppercase tracking-widest mb-4 text-[#ff2a85]">Navegación</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('properties.index') }}" class="hover:text-[#ff2a85] transition">Directorio Inmobiliario</a></li>
                        <li><a href="#" class="hover:text-[#ff2a85] transition">Mapa Satelital</a></li>
                        <li><a href="#" class="hover:text-[#ff2a85] transition">Agentes Registrados</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-extrabold text-white uppercase tracking-widest mb-4 text-[#ff2a85]">Contacto Oficial</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="text-white font-semibold">sgniacompany@corporacion.com</li>
                        <li class="text-slate-300">+52 223 131 6588</li>
                        <li class="text-slate-400">Nopalucan de la Granja, Pue., México</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} SGNIA Real Estate. Todos los derechos reservados.</p>
                <div class="mt-4 sm:mt-0 flex space-x-6">
                    <a href="#" class="hover:text-[#ff2a85] transition">Términos de Servicio</a>
                    <a href="#" class="hover:text-[#ff2a85] transition">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Mouse Spotlight Script -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const spotlight = document.getElementById('cursor-spotlight');
            if (spotlight) {
                spotlight.style.background = `radial-gradient(600px circle at ${e.clientX}px ${e.clientY}px, rgba(255, 42, 133, 0.12), transparent 75%)`;
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
