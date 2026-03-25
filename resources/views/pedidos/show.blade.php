@extends('layouts.plantilla')

@section('content')
    <div class="max-w-3xl mx-auto p-6 mt-10">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('pedidos.index') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600 transition">
                ← Volver a mis pedidos
            </a>
        </div>

        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
            {{-- Encabezado del Ticket --}}
            <div class="bg-gray-900 p-8 text-white flex justify-between items-center">
                <div>
                    <p class="text-orange-500 font-black uppercase tracking-widest text-xs mb-1">Detalle de Orden</p>
                    <h2 class="text-3xl font-black italic">Pedido #{{ $pedido['id'] }}</h2>
                </div>
                <div class="text-right">
                    <span
                        class="px-4 py-1 rounded-full text-xs font-black uppercase tracking-wider
                    {{ $pedido['estado_pedido'] == 'cancelado' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                        {{ $pedido['estado_pedido'] }}
                    </span>
                    <p class="text-gray-400 text-xs mt-2">
                        {{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            {{-- Cuerpo del Detalle --}}
            <div class="p-8">
                <h3 class="text-gray-400 font-bold uppercase text-xs tracking-widest mb-6 border-b pb-2">Productos
                    Solicitados</h3>

                <div class="space-y-6">
                    @foreach ($pedido['detalles'] as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div
                                    class="bg-orange-100 text-orange-600 w-10 h-10 rounded-lg flex items-center justify-center font-black">
                                    {{ $item['cantidad'] }}x
                                </div>
                                <div>
                                    {{-- Si tienes el nombre del platillo en el array, úsalo aquí --}}
                                    <p class="font-bold text-gray-800 text-lg">{{ $item['nombre_platillo'] }}</p>
                                    <p class="text-xs text-gray-400">Unitario: ${{ number_format($item['precio_unitario'], 2) }}</p>
                                </div>
                            </div>
                            <p class="font-black text-gray-900 text-lg">${{ number_format($item['subtotal'], 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 pt-6 border-t border-dashed border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-black text-gray-900">Total Pagado</span>
                        <span class="text-3xl font-black text-orange-600">${{ number_format($pedido['total'], 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Pie de página / Acciones --}}
            <div class="bg-gray-50 p-6 flex justify-center">
                @if ($pedido['estado_pedido'] !== 'cancelado')
                    <form action="{{ route('pedidos.destroy', $pedido['id']) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido?')">
                        @csrf @method('DELETE')
                        <button
                            class="flex items-center gap-2 bg-red-600 text-white px-8 py-3 rounded-xl font-black hover:bg-red-700 transition shadow-lg shadow-red-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            CANCELAR PEDIDO
                        </button>
                    </form>
                @else
                    <p class="text-gray-400 font-bold italic">Este pedido ya no puede ser modificado.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
