@extends('layouts.plantilla')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Finalizar <span class="text-orange-600">Pedido</span></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Resumen de Productos -->
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-2">Resumen de productos</h2>
                @foreach ($carrito as $item)
                    <div class="flex items-center gap-4 bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                        <img src="{{ $item['imagen'] }}" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-grow">
                            <h4 class="font-bold text-gray-800">{{ $item['nombre'] }}</h4>
                            <p class="text-sm text-gray-500">{{ $item['cantidad'] }} x
                                ${{ number_format($item['precio'], 2) }}</p>
                        </div>
                        <p class="font-bold text-gray-900">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Confirmación de Pago -->
            <div class="bg-gray-50 rounded-3xl p-8 border border-gray-200 h-fit">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detalles del Pago</h2>

                <div class="space-y-3 mb-8">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Costo de envío</span>
                        <span class="text-green-600 font-bold">Gratis</span>
                    </div>
                    <div class="flex justify-between text-2xl font-black text-gray-900 pt-4 border-t">
                        <span>Total</span>
                        <span class="text-orange-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('pedidos.store') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl transition-all shadow-xl mb-4 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Confirmar y Pagar ${{ number_format($total, 2) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
