@extends('layouts.plantilla')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 text-center border border-gray-100">

            {{-- Icono de Check --}}
            <div class="mb-6 flex justify-center">
                <div class="bg-green-100 p-4 rounded-full">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-black text-gray-900 mb-2">¡Pedido Recibido!</h1>
            <p class="text-gray-500 mb-6">Tu orden ha sido procesada correctamente.</p>

            {{-- RESUMEN DE COMPRA (Lo nuevo) --}}
            @if(session('resumen'))
            <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4 text-left">Resumen de compra</h3>
                
                <div class="space-y-3">
                    @foreach(session('resumen') as $item)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium">
                            <span class="text-orange-600 font-bold">{{ $item['cantidad'] }}x</span> {{ $item['nombre'] }}
                        </span>
                        <span class="text-gray-900 font-bold">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-dashed border-gray-300 flex justify-between items-center">
                    <span class="text-gray-900 font-black text-lg">Total Pagado:</span>
                    <span class="text-orange-600 font-black text-xl">${{ number_format(session('totalPagado'), 2) }}</span>
                </div>
            </div>
            @endif

            {{-- Estado del flujo --}}
            <div class="space-y-2 mb-8 text-left bg-orange-50/50 p-4 rounded-xl border border-orange-100">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                    <p class="text-xs font-bold text-orange-800 uppercase">Stock actualizado en BD</p>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                    <p class="text-xs font-bold text-orange-800 uppercase">Carrito vaciado</p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="space-y-3">
                <a href="{{ route('pedidos.index') }}"
                    class="block w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-black transition-all shadow-lg">
                    Ver mis pedidos
                </a>
                <a href="{{ route('catalogo') }}"
                    class="block w-full bg-white text-orange-600 border-2 border-orange-100 font-bold py-3 rounded-xl hover:bg-orange-50 transition-all">
                    Seguir comprando
                </a>
            </div>

            <p class="mt-8 text-xs text-gray-400 italic">Gracias por confiar en nosotros.</p>
        </div>
    </div>
@endsection