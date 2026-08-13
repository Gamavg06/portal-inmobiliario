@extends('layouts.app')

@section('title', 'Iniciar Sesión - InmoGeoClima')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900">
                Iniciar Sesión
            </h2>
            <p class="text-sm text-slate-500">
                Accede con cualquier correo o usa las cuentas de prueba
            </p>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Quick Access Buttons for Demo -->
        <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-2">
            <p class="text-xs font-bold uppercase text-indigo-700 tracking-wider text-center">Acceso Rápido de Prueba (1-Clic):</p>
            <div class="grid grid-cols-3 gap-2 text-xs">
                <button type="button" onclick="fillCredentials('admin@inmobiliaria.com', 'password123')" class="px-2 py-2 bg-white text-indigo-800 font-bold rounded-xl border border-indigo-200 hover:bg-indigo-600 hover:text-white transition shadow-sm text-center">
                    👑 Admin
                </button>
                <button type="button" onclick="fillCredentials('agente@inmobiliaria.com', 'password123')" class="px-2 py-2 bg-white text-indigo-800 font-bold rounded-xl border border-indigo-200 hover:bg-indigo-600 hover:text-white transition shadow-sm text-center">
                    💼 Agente
                </button>
                <button type="button" onclick="fillCredentials('comprador@correo.com', 'password123')" class="px-2 py-2 bg-white text-indigo-800 font-bold rounded-xl border border-indigo-200 hover:bg-indigo-600 hover:text-white transition shadow-sm text-center">
                    👤 Comprador
                </button>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-1">
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    value="{{ old('email') }}" 
                    placeholder="correo@ejemplo.com"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium"
                />
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-1">
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium"
                />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm font-medium text-slate-600">
                        Recordarme
                    </label>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-xl shadow-lg shadow-indigo-200 transition duration-200 flex justify-center items-center text-base"
            >
                Entrar al Sistema
            </button>
        </form>

        <!-- Footer link -->
        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-600">
                ¿No tienes cuenta? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Regístrate gratis aquí
                </a>
            </p>
        </div>

    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
