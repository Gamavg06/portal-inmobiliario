@extends('layouts.app')

@section('title', 'Registro de Usuario - SGNIA Real Estate')

@section('content')
<div class="min-h-[85vh] flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="w-full max-w-md space-y-6 bg-slate-900/95 p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-2xl backdrop-blur-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 text-white shadow-md">
                <span class="brand-font font-black text-xl">S</span>
            </div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">
                Crear una Cuenta
            </h2>
            <p class="text-xs text-slate-400 font-medium">
                SGNIA Real Estate • Explora o publica inmuebles satelitales
            </p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-800/60 text-rose-300 text-xs font-bold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Nombre Completo
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    required 
                    value="{{ old('name') }}" 
                    placeholder="Tu Nombre"
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    value="{{ old('email') }}" 
                    placeholder="correo@ejemplo.com"
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Tipo de Cuenta / Rol
                </label>
                <select 
                    name="role" 
                    id="role" 
                    required 
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 text-white font-medium text-sm transition duration-200"
                >
                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }} class="bg-[#0b0f19] text-white">Comprador / Cliente (Explorar y Contactar)</option>
                    <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }} class="bg-[#0b0f19] text-white">Agente Inmobiliario (Publicar Inmuebles)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} class="bg-[#0b0f19] text-white">Administrador General</option>
                </select>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    placeholder="Mínimo 6 caracteres"
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Confirmar Contraseña
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    required 
                    placeholder="Repite tu contraseña"
                    class="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-white font-medium text-sm transition duration-200"
                />
            </div>

            <button 
                type="submit" 
                class="w-full py-3.5 px-4 bg-slate-100 hover:bg-white text-slate-950 font-extrabold rounded-xl shadow-md transition duration-200 text-sm tracking-wide mt-2"
            >
                Registrar Cuenta en SGNIA
            </button>
        </form>

        <div class="text-center pt-3 border-t border-slate-800">
            <p class="text-xs text-slate-400 font-medium">
                ¿Ya tienes cuenta en el portal? 
                <a href="{{ route('login') }}" class="font-extrabold text-white hover:underline ml-1">
                    Inicia sesión aquí
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
