@extends('layouts.plantilla')

@section('content')
    <div class="max-w-6xl mx-auto p-6 mt-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Mis <span class="text-orange-600">Pedidos</span></h2>
            <a href="{{ route('catalogo') }}" class="text-sm font-bold text-orange-600 hover:underline">← Volver al Menú</a>
        </div>

        @if (empty($pedidos))
            <div class="bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-200">
                <p class="text-gray-500 text-lg mb-4">Aún no has realizado ningún pedido.</p>
                <a href="{{ route('catalogo') }}"
                    class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition">
                    ¡Hacer mi primer pedido!
                </a>
            </div>
        @else
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest">Orden</th>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest">Fecha</th>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest">Total</th>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest">Estado Orden</th>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest">Pago</th>
                            <th class="p-5 uppercase text-xs font-bold tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($pedidos as $p)
                            @php
                                $estadoPago = $p['estado_pago'] ?? 'pendiente';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-5 font-mono font-bold text-gray-700">#{{ $p['id'] }}</td>
                                <td class="p-5 text-gray-600 text-sm">
                                    {{ \Carbon\Carbon::parse($p['fecha_pedido'])->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-5 font-black text-gray-900">${{ number_format($p['total'], 2) }}</td>

                                {{-- Estado del Pedido --}}
                                <td class="p-5">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $p['estado_pedido'] == 'cancelado' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $p['estado_pedido'] }}
                                    </span>
                                </td>

                                {{-- Estado del Pago --}}
                                <td class="p-5">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $estadoPago == 'completado' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $estadoPago }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="p-5 flex justify-center items-center gap-3">
                                    {{-- 1. Pagar --}}
                                    @if ($p['estado_pedido'] !== 'cancelado' && $estadoPago !== 'completado')
                                        <a href="{{ route('pedidos.pagar', $p['id']) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] hover:bg-blue-700 transition shadow-md shadow-blue-200 flex items-center gap-1 uppercase">
                                            Pagar
                                        </a>
                                    @endif

                                    {{-- 2. Detalles --}}
                                    <a href="{{ route('pedidos.show', $p['id']) }}"
                                        class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg font-bold text-[10px] hover:bg-gray-900 hover:text-white transition uppercase">
                                        Detalles
                                    </a>

                                    {{-- 3. Cancelar (Solo si no está pagado Y no está ya cancelado) --}}
                                    @if ($estadoPago !== 'completado' && $p['estado_pedido'] !== 'cancelado')
                                        <form action="{{ route('pedidos.destroy', $p['id']) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-[10px] uppercase">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection