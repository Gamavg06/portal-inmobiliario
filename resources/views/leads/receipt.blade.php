@extends('layouts.app')

@section('title', 'Ficha de Pre-Apartado SGNIA-RES-2026-00' . $lead->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Receipt Container Card -->
    <div class="bg-slate-900/95 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden backdrop-blur-xl">
        
        <!-- Header Ribbon -->
        <div class="bg-slate-950 p-6 sm:p-8 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-white font-extrabold text-xl shadow-md">
                    S
                </div>
                <div>
                    <span class="brand-font text-2xl font-extrabold text-white tracking-tight">SGNIA<span class="text-slate-400">.</span></span>
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Ficha Oficial de Pre-Apartado</span>
                </div>
            </div>

            <div class="text-right">
                <span class="text-xs font-mono text-slate-400 block">Folio de Reserva:</span>
                <span class="text-sm font-black font-mono text-white">SGNIA-RES-2026-00{{ $lead->id }}</span>
            </div>
        </div>

        <div class="p-6 sm:p-10 space-y-8" id="receipt-content">

            <!-- Status Banner -->
            <div class="flex items-center justify-between p-4 rounded-2xl border 
                {{ $lead->status === 'paid' ? 'bg-emerald-950/80 border-emerald-500/40 text-emerald-300' : 'bg-slate-950 border-slate-800 text-slate-300' }}
            ">
                <div class="flex items-center space-x-3">
                    @if($lead->status === 'paid')
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold text-lg">✓</div>
                        <div>
                            <h4 class="font-extrabold text-white text-base">¡Inmueble Reservado Exitosamente!</h4>
                            <p class="text-xs text-emerald-300">Pago confirmado en línea vía PayPal. ID Transacción: <span class="font-mono font-bold">{{ $lead->paypal_transaction_id }}</span></p>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 font-bold text-lg">📋</div>
                        <div>
                            <h4 class="font-extrabold text-white text-base">Ficha Aprobada por Agente</h4>
                            <p class="text-xs text-slate-400">Pendiente de confirmación del pago de apartado ($ MXN)</p>
                        </div>
                    @endif
                </div>

                <span class="px-3.5 py-1 text-xs font-black uppercase tracking-wider rounded-full border 
                    {{ $lead->status === 'paid' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : 'bg-slate-800 text-slate-200 border-slate-700' }}
                ">
                    {{ $lead->status === 'paid' ? 'Reservado 🔒' : 'Aprobado (Pago Pendiente)' }}
                </span>
            </div>

            <!-- Official Company Data Header for Paid Receipts -->
            @if($lead->status === 'paid')
                <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 space-y-3">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-800 pb-3 gap-2">
                        <div>
                            <span class="text-xs font-extrabold text-slate-300 uppercase tracking-widest block">EMISOR DEL COMPROBANTE:</span>
                            <h3 class="text-lg font-extrabold text-white">SGNIA Real Estate S.A. de C.V.</h3>
                            <p class="text-xs text-slate-400">RFC: <span class="font-mono text-slate-300 font-bold">SGN-260721-H80</span></p>
                        </div>
                        <div class="text-left sm:text-right text-xs text-slate-400">
                            <span class="block font-bold text-white">Fecha de Transacción:</span>
                            <span>{{ $lead->updated_at ? $lead->updated_at->format('d/m/Y h:i:s A') : date('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-300 pt-1">
                        <div>
                            <span class="text-slate-400 block font-semibold">Dirección Oficial:</span>
                            <span>Avenida 2 Poniente 4, Centro, 75120 Nopalucan de la Granja, Pue., México</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Contacto Oficial:</span>
                            <span>Tel: +52 223 131 6588 | Email: sgniacompany@corporacion.com</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Property Details Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-950 p-6 rounded-2xl border border-slate-800/80">
                <div class="md:col-span-2 space-y-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Inmueble Seleccionado</span>
                    <h3 class="text-xl font-extrabold text-white">{{ $lead->property->title }}</h3>
                    <p class="text-xs text-slate-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {{ $lead->property->address }}
                    </p>
                </div>

                <div class="text-right space-y-1 border-t md:border-t-0 md:border-l border-slate-800 pt-4 md:pt-0 md:pl-6">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block">Precio Total</span>
                    <span class="text-xl font-black text-white block">${{ number_format($lead->property->price, 2, ',', '.') }} MXN</span>
                    <span class="text-xs font-bold text-slate-400 block mt-2">Monto de Enganche Pagado:</span>
                    <span class="text-2xl font-black text-emerald-400 block">${{ number_format($lead->reservation_amount, 2, ',', '.') }} MXN</span>
                    @if($lead->status === 'paid')
                        <span class="text-[10px] font-bold text-slate-400 block mt-1">Saldo a Escrituración:</span>
                        <span class="text-xs font-mono font-bold text-slate-300 block">${{ number_format($lead->property->price - $lead->reservation_amount, 2, ',', '.') }} MXN</span>
                    @endif
                </div>
            </div>

            <!-- People Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 space-y-1">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Cliente Comprador</span>
                    <p class="font-extrabold text-white text-sm">{{ $lead->user ? $lead->user->name : 'Cliente Interesado' }}</p>
                    <p class="text-xs text-slate-400">{{ $lead->user ? $lead->user->email : '-' }}</p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 space-y-1">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Agente SGNIA Asignado</span>
                    <p class="font-extrabold text-white text-sm">{{ $lead->property->user ? $lead->property->user->name : 'Agente SGNIA' }}</p>
                    <p class="text-xs text-slate-400">Nopalucan de la Granja, Puebla</p>
                </div>
            </div>

            <!-- PayPal Payment Section / Print Action -->
            @if($lead->status !== 'paid')
                <div class="p-6 sm:p-8 rounded-3xl bg-slate-950 border border-slate-800 space-y-6 text-center">
                    <div class="max-w-md mx-auto space-y-2">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-slate-300">Pagar Apartado en Línea ($ MXN)</span>
                        <h3 class="text-2xl font-extrabold text-white">Total a Pagar: ${{ number_format($lead->reservation_amount, 2, ',', '.') }} MXN</h3>
                        <p class="text-xs text-slate-400">
                            Procesa tu pago de forma 100% segura con saldo PayPal o Tarjeta de Crédito/Débito.
                        </p>
                    </div>

                    <!-- PayPal SDK Buttons Container -->
                    <div class="max-w-md mx-auto pt-2">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            @else
                <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
                    <div>
                        <p class="text-xs text-slate-300 font-bold">Comprobante Oficial de Reserva Confirmada por SGNIA Real Estate.</p>
                        <p class="text-[11px] text-slate-400">Conserva este recibo digital para tu proceso de escrituración.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="window.print()" class="px-5 py-2.5 bg-slate-100 hover:bg-white text-slate-950 font-black text-xs rounded-xl transition shadow-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            🖨️ Imprimir / Guardar PDF
                        </button>
                        <a href="{{ route('properties.show', $lead->property->id) }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs rounded-xl transition">
                            ← Volver a Inmueble
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection

@section('scripts')
@if($lead->status !== 'paid')
    <!-- PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=MXN&locale=es_MX"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.paypal) {
                paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        color:  'gold',
                        shape:  'rect',
                        label:  'paypal'
                    },

                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '{{ number_format($lead->reservation_amount, 2, '.', '') }}',
                                    currency_code: 'MXN'
                                },
                                description: 'Reserva Inmobiliaria Folio SGNIA-RES-2026-00{{ $lead->id }}'
                            }]
                        });
                    },

                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            const transactionId = details.id || data.orderID;
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            fetch("{{ route('leads.pay-paypal', $lead->id) }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    paypal_transaction_id: transactionId
                                })
                            })
                            .then(response => response.json())
                            .then(res => {
                                if (res.success) {
                                    alert('¡Pago de apartado registrado con éxito en PayPal!');
                                    window.location.reload();
                                }
                            })
                            .catch(err => {
                                console.error('Error al registrar pago en servidor:', err);
                                alert('El pago fue autorizado en PayPal pero hubo un problema al actualizar la sesión.');
                            });
                        });
                    },

                    onError: function(err) {
                        console.error('PayPal SDK Error:', err);
                        alert('Ocurrió un inconveniente al abrir la ventana de pago de PayPal.');
                    }
                }).render('#paypal-button-container');
            }
        });
    </script>
@endif
<style>
@media print {
    nav, footer, .no-print {
        display: none !important;
    }
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
    }
    .bg-slate-900\/95, .bg-slate-950 {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #0f172a !important;
        box-shadow: none !important;
    }
    h1, h2, h3, h4, span, p {
        color: #0f172a !important;
    }
    .text-emerald-400, .text-emerald-300 {
        color: #059669 !important;
    }
}
</style>
@endsection

