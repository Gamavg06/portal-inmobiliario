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

            <!-- Custom Segmented Role Selector (Only Cliente and Agente) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                    Tipo de Cuenta / Rol
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="buyer" class="peer sr-only" {{ old('role', 'buyer') == 'buyer' ? 'checked' : '' }}>
                        <div class="p-3 bg-slate-950 border border-slate-800 rounded-xl peer-checked:border-slate-300 peer-checked:bg-slate-800/90 transition text-center space-y-0.5">
                            <span class="block text-xs font-extrabold text-white">👤 Cliente</span>
                            <span class="block text-[10px] text-slate-400 leading-tight">Explorar y Contactar</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="agent" class="peer sr-only" {{ old('role') == 'agent' ? 'checked' : '' }}>
                        <div class="p-3 bg-slate-950 border border-slate-800 rounded-xl peer-checked:border-slate-300 peer-checked:bg-slate-800/90 transition text-center space-y-0.5">
                            <span class="block text-xs font-extrabold text-white">💼 Agente Inmobiliario</span>
                            <span class="block text-[10px] text-slate-400 leading-tight">Requiere Aprobación</span>
                        </div>
                    </label>
                </div>
                <p class="text-[11px] text-slate-400 mt-2 italic">
                    * Las cuentas de Agente Inmobiliario son revisadas y activadas por el Administrador General.
                </p>
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
