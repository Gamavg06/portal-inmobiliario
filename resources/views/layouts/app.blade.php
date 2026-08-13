<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal Inmobiliario - Encuentra tu Hogar Ideal')</title>
    <meta name="description" content="@yield('meta_description', 'Encuentra las mejores casas, departamentos y locales comerciales con ubicación exacta y clima en tiempo real.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet.js (Mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('properties.index') }}" class="flex items-center space-x-2 group">
                        <div class="p-2 bg-indigo-600 text-white rounded-xl shadow-md shadow-indigo-200 group-hover:bg-indigo-700 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 group-hover:text-indigo-600 transition duration-200">InmoGeoClima</span>
                    </a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('properties.index') }}" class="text-sm font-semibold {{ request()->routeIs('properties.index') ? 'text-indigo-600' : 'text-slate-500 hover:text-slate-900' }} transition">
                        Propiedades
                    </a>
                    <a href="#" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition">Agentes</a>
                    <a href="#" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition">Sobre Nosotros</a>
                </nav>
                <div class="flex items-center space-x-3">
                    @auth
                        @if(in_array(Auth::user()->role, ['admin', 'agent']))
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-3.5 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-xl hover:bg-indigo-600 hover:text-white transition duration-200">
                                👑 Panel Admin
                            </a>
                            <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition duration-200">
                                + Publicar
                            </a>
                        @endif

                        <div class="flex items-center space-x-2 border-l border-slate-200 pl-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-extrabold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    {{ Auth::user()->role === 'admin' ? 'Admin' : (Auth::user()->role === 'agent' ? 'Agente' : 'Comprador') }}
                                </span>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-xl transition duration-200">
                                    Salir
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-xl transition duration-200">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition duration-200">
                            Registrarse
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-bold flex items-center space-x-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <div class="p-1.5 bg-indigo-600 text-white rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-white tracking-tight">InmoGeoClima</span>
                    </div>
                    <p class="text-sm max-w-sm">
                        La primera plataforma inmobiliaria universitaria que integra mapas interactivos geolocalizados y clima en tiempo real para brindarte la mejor información de tu futuro hogar.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Enlaces Útiles</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('properties.index') }}" class="hover:text-white transition">Directorio</a></li>
                        <li><a href="#" class="hover:text-white transition">Buscar Mapa</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog de Noticias</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Contacto</h3>
                    <ul class="space-y-2 text-sm">
                        <li>sgniacompany@corporacion.com</li>
                        <li>+52 223 131 6588</li>
                        <li>Nopalucan de la Granja, Pue., México</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center text-xs">
                <p>&copy; {{ date('Y') }} InmoGeoClima. Todos los derechos reservados. Proyecto Universitario.</p>
                <div class="mt-4 sm:mt-0 flex space-x-6">
                    <a href="#" class="hover:text-white transition">Términos de Servicio</a>
                    <a href="#" class="hover:text-white transition">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
