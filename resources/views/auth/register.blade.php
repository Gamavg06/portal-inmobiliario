@extends('layouts.app')

@section('title', 'Registro de Usuario - SGNIA Real Estate')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-[#110d22]/90 p-8 sm:p-10 rounded-3xl border border-slate-800/80 shadow-2xl backdrop-blur-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#ff2a85] to-purple-600 text-white shadow-neon mb-2">
                <span class="brand-font font-black text-2xl">S</span>
            </div>
            <h2 class="text-3xl font-black text-white">
                Crear una Cuenta
            </h2>
            <p class="text-xs text-slate-400">
                SGNIA Real Estate • Explora o publica inmuebles satelitales
            </p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="mt-8 space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-xs font-extrabold uppercase text-slate-300 mb-1">
                    Nombre Completo
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    required 
                    value="{{ old('name') }}" 
                    placeholder="Tu Nombre"
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] text-white font-medium"
                />
            </div>

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
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] text-white font-medium"
                />
            </div>

            <div>
                <label for="role" class="block text-xs font-extrabold uppercase text-slate-300 mb-1">
                    Tipo de Cuenta / Rol
                </label>
                <select 
                    name="role" 
                    id="role" 
                    required 
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] text-white font-medium"
                >
                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Comprador / Cliente (Explorar y Contactar)</option>
                    <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agente Inmobiliario (Publicar Inmuebles)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador General</option>
                </select>
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
                    placeholder="Mínimo 6 caracteres"
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] text-white font-medium"
                />
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-extrabold uppercase text-slate-300 mb-1">
                    Confirmar Contraseña
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    required 
                    placeholder="Repite la contraseña"
                    class="w-full px-4 py-3 rounded-xl bg-[#090710] border border-slate-800 focus:border-[#ff2a85] text-white font-medium"
                />
            </div>

            <button 
                type="submit" 
                class="w-full py-3.5 px-4 bg-gradient-to-r from-[#ff2a85] to-purple-600 hover:from-[#e01f73] hover:to-purple-700 text-white font-black rounded-xl shadow-neon transition duration-200 text-base mt-2"
            >
                Registrar en SGNIA
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-800">
            <p class="text-xs text-slate-400">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-bold text-[#ff2a85] hover:underline">
                    Inicia sesión aquí
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
