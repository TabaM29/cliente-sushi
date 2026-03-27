@extends('layouts.plantilla')

@section('content')
    <div class="max-w-3xl mx-auto p-6 mt-10">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('pedidos.index') }}" class="text-sm font-bold text-gray-500 hover:text-orange-600 transition">
                ← Volver a mis pedidos
            </a>

            @if (session('mensaje'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-bold text-xs animate-bounce">
                    {{ session('mensaje') }}
                </div>
            @endif
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
                        Creado: {{ \Carbon\Carbon::parse($pedido['fecha_pedido'])->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            {{-- SECCIÓN DE PAGO --}}
            @if (!empty($pedido['id_transaccion']))
                <div class="bg-blue-600 p-6 text-white border-b border-blue-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-500 p-3 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.2em]">Pago Confirmado
                                    vía PayPal</p>
                                <h4 class="text-lg font-bold leading-tight">Transacción Exitosa</h4>
                                <p class="text-blue-100 text-xs mt-1 font-mono">ID: {{ $pedido['id_transaccion'] }}</p>
                            </div>
                        </div>
                        {{-- Muestra la fecha de pago usando la última actualización del pedido --}}
                        <div class="text-right border-l border-blue-500 pl-4">
                            <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.2em]">Fecha de Pago</p>
                            <p class="text-white font-bold text-sm">
                                {{ \Carbon\Carbon::parse($pedido['updated_at'])->timezone('America/Mexico_City')->format('d/m/Y h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

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
                                    <p class="font-bold text-gray-800 text-lg">{{ $item['nombre_platillo'] }}</p>
                                    <p class="text-xs text-gray-400">Unitario:
                                        ${{ number_format($item['precio_unitario'], 2) }}</p>
                                </div>
                            </div>
                            <p class="font-black text-gray-900 text-lg">${{ number_format($item['subtotal'], 2) }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Resumen Final --}}
                <div class="mt-10 pt-6 border-t border-dashed border-gray-200">
                    <div class="flex justify-between items-center mb-2 text-gray-500 text-sm">
                        <span>Método de Pago:</span>
                        <span class="font-bold">{{ $pedido['metodo_pago'] ?? 'PayPal' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-6 text-gray-500 text-sm">
                        <span>Estado de Transacción:</span>
                        <span
                            class="font-bold uppercase {{ ($pedido['estado_pago'] ?? '') == 'completado' ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $pedido['estado_pago'] ?? 'Pendiente' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-black text-gray-900">Total</span>
                        <span class="text-3xl font-black text-orange-600">${{ number_format($pedido['total'], 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="bg-gray-50 p-8 border-t border-gray-100">
                <div class="flex flex-col items-center gap-4">
                    {{-- Botón Pagar --}}
                    @if ($pedido['estado_pedido'] !== 'cancelado' && empty($pedido['id_transaccion']))
                        <a href="{{ route('pedidos.pagar', $pedido['id']) }}"
                            class="w-full text-center bg-blue-600 text-white px-8 py-4 rounded-2xl font-black hover:bg-blue-700 transition shadow-lg shadow-blue-200 uppercase tracking-widest">
                            Ir a Pagar Ahora
                        </a>
                    @endif

                    {{-- Botón Cancelar --}}
                    @if (($pedido['estado_pago'] ?? '') !== 'completado' && $pedido['estado_pedido'] !== 'cancelado')
                        <form action="{{ route('pedidos.destroy', $pedido['id']) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido?');"
                            class="w-full text-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-400 font-bold uppercase text-xs tracking-widest hover:text-red-600 transition">
                                Cancelar Pedido
                            </button>
                        </form>
                    @elseif(($pedido['estado_pago'] ?? '') === 'completado')
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">
                            Orden protegida: Los pedidos pagados no pueden cancelarse.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
