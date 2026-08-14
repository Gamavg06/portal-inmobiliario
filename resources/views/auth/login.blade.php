@extends('layouts.app')

@section('title', 'Iniciar Sesión - SGNIA Real Estate')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-[#110d22]/90 p-8 sm:p-10 rounded-3xl border border-slate-800/80 shadow-2xl backdrop-blur-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#ff2a85] to-purple-600 text-white shadow-neon mb-2">
                <span class="brand-font font-black text-2xl">S</span>
            </div>
            <h2 class="text-3xl font-black text-white">
                Acceso al Portal
            </h2>
            <p class="text-xs text-slate-400">
                SGNIA Real Estate • Ingresa con cualquier correo o cuenta de prueba
            </p>
        </div>

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-sm font-semibold flex items-center">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Quick Access Buttons for Demo -->
        <div class="p-4 rounded-2xl bg-[#090710] border border-[#ff2a85]/20 space-y-2">
            <p class="text-[10px] font-extrabold uppercase text-[#ff2a85] tracking-widest text-center">Acceso Rápido de Prueba (1-Clic):</p>
            <div class="grid grid-cols-3 gap-2 text-xs">
                <button type="button" onclick="fillCredentials('admin@inmobiliaria.com', 'password123')" class="px-2 py-2 bg-[#17122b] text-white font-bold rounded-xl border border-slate-800 hover:border-[#ff2a85] hover:text-[#ff2a85] transition text-center">
                    👑 Admin
                </button>
                <button type="button" onclick="fillCredentials('agente@inmobiliaria.com', 'password123')" class="px-2 py-2 bg-[#17122b] text-white font-bold rounded-xl border border-slate-800 hover:border-[#ff2a85] hover:text-[#ff2a85] transition text-center">
                    💼 Agente
                </button>
                <button type="button" onclick="fillCredentials('comprador@correo.com', 'password123')" class="px-2 py-2 bg-[#17122b] text-white font-bold rounded-xl border border-slate-800 hover:border-[#ff2a85] hover:text-[#ff2a85] transition text-center">
                    👤 Comprador
                </button>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-xs font-extrabold uppercase text-slate-300 mb-1">
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    value="{{ old('email') }}" 
                    placeholder="correo@ejemplo.com"
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] focus:ring-1 focus:ring-[#ff2a85] text-white font-medium"
                />
            </div>

            <div>
                <label for="password" class="block text-xs font-extrabold uppercase text-slate-300 mb-1">
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] focus:ring-1 focus:ring-[#ff2a85] text-white font-medium"
                />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-[#ff2a85] focus:ring-[#ff2a85] bg-[#090710] border-slate-800 rounded"
                    >
                    <label for="remember" class="ml-2 block text-xs font-bold text-slate-400">
                        Recordarme
                    </label>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full py-3.5 px-4 bg-gradient-to-r from-[#ff2a85] to-purple-600 hover:from-[#e01f73] hover:to-purple-700 text-white font-black rounded-xl shadow-neon transition duration-200 text-base"
            >
                Entrar a SGNIA
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-800">
            <p class="text-xs text-slate-400">
                ¿No tienes cuenta? 
                <a href="{{ route('register') }}" class="font-bold text-[#ff2a85] hover:underline">
                    Regístrate aquí
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
