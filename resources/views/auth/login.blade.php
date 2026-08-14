@extends('layouts.app')

@section('title', 'Iniciar Sesión - SGNIA Real Estate')

@section('content')
<div class="min-h-[82vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full space-y-8 bg-slate-900/90 p-8 sm:p-10 rounded-3xl border border-slate-800 shadow-2xl backdrop-blur-xl">
        
        <!-- Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-slate-800 border border-slate-700 text-white shadow-md mb-1">
                <span class="brand-font font-black text-2xl">S</span>
            </div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Iniciar Sesión
            </h2>
            <p class="text-xs text-slate-400 font-medium">
                SGNIA Real Estate • Nopalucan de la Granja, Puebla
            </p>
        </div>

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-800/60 text-rose-300 text-xs font-bold flex items-center">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-800/60 text-rose-300 text-xs font-bold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form id="login-form" action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    value="{{ old('email') }}" 
                    placeholder="correo@ejemplo.com"
                    class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-slate-400 focus:ring-slate-400 bg-slate-950 border-slate-800 rounded"
                    >
                    <label for="remember" class="ml-2 block text-xs font-bold text-slate-400">
                        Recordar mi sesión
                    </label>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full py-4 px-4 bg-slate-100 hover:bg-white text-slate-950 font-extrabold rounded-xl shadow-md transition duration-200 text-sm tracking-wide mt-2"
            >
                Entrar a SGNIA Real Estate
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-800">
            <p class="text-xs text-slate-400 font-medium">
                ¿No tienes cuenta en el portal? 
                <a href="{{ route('register') }}" class="font-extrabold text-white hover:underline ml-1">
                    Regístrate aquí gratis
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
