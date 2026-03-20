@extends('layouts.plantilla')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900">Tu <span class="text-orange-600">Carrito</span></h1>
            <a href="{{ route('catalogo') }}"
                class="text-gray-500 hover:text-orange-600 font-medium flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Seguir comprando
            </a>
        </div>

        @if (session('carrito') && count(session('carrito')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-4">
                    @foreach ($carrito as $id => $detalles)
                        <div
                            class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-24 h-24 flex-shrink-0">
                                <img src="{{ $detalles['imagen'] }}"
                                    class="w-full h-full object-cover rounded-xl shadow-inner">
                            </div>

                            <div class="flex-grow text-center sm:text-left">
                                <h3 class="text-lg font-bold text-gray-800">{{ $detalles['nombre'] }}</h3>
                                <p class="text-orange-600 font-semibold text-sm">
                                    ${{ number_format($detalles['precio'], 2) }} c/u</p>
                            </div>

                            <div class="flex items-center bg-gray-50 rounded-lg p-1 border border-gray-100">
                                <form action="{{ route('carrito.update') }}" method="POST" class="flex items-center">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="cantidad" value="{{ $detalles['cantidad'] }}" min="1"
                                        onchange="this.form.submit()"
                                        class="w-12 bg-transparent text-center font-bold text-gray-700 border-none focus:ring-0">
                                    
                                </form>
                            </div>

                            <div class="text-right flex flex-col items-end gap-2 min-w-[100px]">
                                <p class="font-bold text-gray-900 text-lg">
                                    ${{ number_format($detalles['precio'] * $detalles['cantidad'], 2) }}</p>
                                <form action="{{ route('carrito.remove') }}" method="POST">
                                    @csrf @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-4">
                        <a href="{{ route('carrito.clear') }}"
                            class="inline-flex items-center text-sm text-gray-400 hover:text-red-500 transition-colors gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Vaciar todo el carrito
                        </a>
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- Área de resumen de pedido --}}
                {{-- ========================= --}}

                <div class="lg:col-span-1">
                    <div class="bg-gray-900 text-white rounded-3xl p-8 sticky top-24">
                        <h2 class="text-xl font-bold mb-6 border-b border-gray-800 pb-4">Resumen</h2>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Envío</span>
                                <span class="text-green-400 font-medium">Gratis</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold pt-4 border-t border-gray-800">
                                <span>Total</span>
                                <span class="text-orange-500">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-xl transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-orange-900/20">
                            Finalizar Pedido
                        </button>

                        <p class="text-[10px] text-gray-500 mt-6 text-center uppercase tracking-widest font-bold">
                            Pago seguro garantizado por SushiZen
                        </p>
                    </div>
                </div>
            </div>
            {{-- Aquí termina --}}
        @else
            <div class="bg-gray-50 rounded-3xl p-20 text-center border-2 border-dashed border-gray-200">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-8">¡Añade algunos rollos de sushi para empezar!</p>
                <a href="{{ route('catalogo') }}"
                    class="bg-orange-600 text-white px-8 py-3 rounded-full font-bold hover:bg-orange-700 transition-all">
                    Ver Menú
                </a>
            </div>
        @endif
    </div>
@endsection
