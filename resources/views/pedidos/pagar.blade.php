@extends('layouts.plantilla')

@section('content')
    <div class="max-w-xl mx-auto p-6 mt-10">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
            {{-- Encabezado --}}
            <div class="bg-gray-900 p-8 text-center">
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter">
                    Finalizar <span class="text-orange-500">Pago</span>
                </h2>
                <p class="text-gray-400 text-sm mt-1">
                    Pedido #{{ $pedido['id'] ?? ($pedido->id ?? 'N/A') }}
                </p>
            </div>

            <div class="p-8">
                {{-- Resumen de la cuenta --}}
                <div class="flex justify-between items-center mb-6 p-6 bg-orange-50 rounded-2xl border border-orange-100">
                    <div>
                        <p class="text-xs font-bold text-orange-800 uppercase tracking-widest">Total a pagar</p>
                        <p class="text-4xl font-black text-orange-600">
                            ${{ number_format($pedido['total'] ?? $pedido->total, 2) }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-bold uppercase">Moneda</p>
                        <p class="text-lg font-bold text-gray-700">MXN</p>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Validamos si el pedido ya fue pagado para ocultar los botones --}}
                    @if(($pedido['estado_pago'] ?? $pedido->estado_pago) !== 'completado')
                        <p class="text-center text-gray-500 text-sm mb-4">Elige tu método de pago seguro:</p>

                        {{-- Contenedor de PayPal --}}
                        <div id="paypal-button-container" class="px-2"></div>
                    @else
                        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl text-center">
                            <i class="fas fa-check-circle mb-2 text-2xl"></i>
                            <p class="font-bold">Este pedido ya ha sido pagado y está en preparación.</p>
                        </div>
                    @endif
                </div>

                {{-- Solo mostramos la opción de cancelar si el pedido está pendiente de pago --}}
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    @if(($pedido['estado_pago'] ?? $pedido->estado_pago) !== 'completado')
                        <a href="{{ route('pedidos.index') }}"
                            class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
                            ← Cancelar y volver a mis pedidos
                        </a>
                    @else
                        <a href="{{ route('pedidos.index') }}"
                            class="inline-block bg-gray-900 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-gray-800 transition">
                            Volver a mis pedidos
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts de PayPal --}}
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=MXN"></script>
    
    <script>
        if (document.getElementById('paypal-button-container')) {
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                // Usamos el total asegurándonos que sea el formato correcto
                                value: '{{ $pedido['total'] ?? $pedido->total }}'
                            }
                        }]
                    });
                },

                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        // Redirección a la ruta de confirmación que definimos en web.php
                        const pedidoId = "{{ $pedido['id'] ?? $pedido->id }}";
                        window.location.href = `/pedidos/confirmar-pago/${pedidoId}/${details.id}`;
                    });
                },

                onCancel: function(data) {
                    alert("Has cerrado la ventana de pago. El pedido sigue pendiente.");
                },

                onError: function(err) {
                    console.error('Error en el flujo de PayPal:', err);
                    alert("Ocurrió un error con el pago. Por favor, intenta de nuevo.");
                }
            }).render('#paypal-button-container');
        }
    </script>
@endsection