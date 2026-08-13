@extends('layouts.app')

@section('title', 'Registro de Usuario - InmoGeoClima')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-100 shadow-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900">
                Crear una Cuenta
            </h2>
            <p class="text-sm text-slate-500">
                Únete para explorar o publicar inmuebles
            </p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('register.post') }}" method="POST" class="mt-8 space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-1">
                    Nombre Completo
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    required 
                    value="{{ old('name') }}" 
                    placeholder="Tu Nombre"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium"
                />
            </div>

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
                <label for="role" class="block text-sm font-bold text-slate-700 mb-1">
                    Tipo de Cuenta / Rol
                </label>
                <select 
                    name="role" 
                    id="role" 
                    required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium bg-white"
                >
                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Comprador / Cliente (Explorar y Contactar)</option>
                    <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agente Inmobiliario (Publicar Inmuebles)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador General</option>
                </select>
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
                    placeholder="Mínimo 6 caracteres"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium"
                />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">
                    Confirmar Contraseña
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    required 
                    placeholder="Repite la contraseña"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 font-medium"
                />
            </div>

            <button 
                type="submit" 
                class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-xl shadow-lg shadow-indigo-200 transition duration-200 flex justify-center items-center text-base mt-2"
            >
                Registrar Cuenta
            </button>
        </form>

        <!-- Footer link -->
        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-600">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                    Inicia sesión aquí
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
