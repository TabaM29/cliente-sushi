@extends('layouts.plantilla')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 text-center border border-gray-100">

            {{-- Icono de Reloj o Tarjeta para indicar "Pendiente de Pago" --}}
            <div class="mb-6 flex justify-center">
                <div class="bg-blue-100 p-4 rounded-full animate-pulse">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-black text-gray-900 mb-2">¡Orden Generada!</h1>
            <p class="text-gray-500 mb-6 font-medium">Solo falta un paso para procesar tu pedido.</p>

            {{-- RESUMEN DE COMPRA --}}
            @if(session('resumen'))
            <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Resumen</h3>
                    <span class="text-[10px] bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full font-bold uppercase">Pendiente</span>
                </div>
                
                <div class="space-y-3">
                    @foreach(session('resumen') as $item)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium text-left">
                            <span class="text-orange-600 font-bold">{{ $item['cantidad'] }}x</span> {{ $item['nombre'] }}
                        </span>
                        <span class="text-gray-900 font-bold">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-dashed border-gray-300 flex justify-between items-center">
                    <span class="text-gray-900 font-black text-lg">Total a Pagar:</span>
                    <span class="text-orange-600 font-black text-xl">${{ number_format(session('totalPagado'), 2) }}</span>
                </div>
            </div>
            @endif

            {{-- BOTÓN PRINCIPAL: IR A PAGAR --}}
            <div class="space-y-3">
                @if(session('pedido_id'))
                    <a href="{{ route('pedidos.pagar', session('pedido_id')) }}"
                        class="block w-full bg-blue-600 text-white font-black py-5 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-100 uppercase tracking-widest text-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Pagar Ahora con PayPal
                    </a>
                @endif

                <a href="{{ route('pedidos.index') }}"
                    class="block w-full bg-gray-100 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-200 transition-all text-xs">
                    Ver detalles del pedido y pagar después
                </a>
            </div>

            <p class="mt-8 text-[10px] text-gray-400 uppercase tracking-widest font-bold">Pago seguro procesado por PayPal</p>
        </div>
    </div>
@endsection