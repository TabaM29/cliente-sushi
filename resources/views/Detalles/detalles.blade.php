@extends('layouts.plantilla')

@section('content')
@php $producto = (object) $producto; @endphp

<div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        
        <div class="space-y-4">
            <div class="relative h-96 overflow-hidden rounded-2xl shadow-lg border">
                <img id="current-img" src="{{ $producto->imagen1 }}" class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <button onclick="document.getElementById('current-img').src='{{ $producto->imagen1 }}'" class="rounded-lg overflow-hidden border hover:border-orange-500 transition">
                    <img src="{{ $producto->imagen1 }}" class="h-24 w-full object-cover">
                </button>
                <button onclick="document.getElementById('current-img').src='{{ $producto->imagen2 }}'" class="rounded-lg overflow-hidden border hover:border-orange-500 transition">
                    <img src="{{ $producto->imagen2 }}" class="h-24 w-full object-cover">
                </button>
                <button onclick="document.getElementById('current-img').src='{{ $producto->imagen3 }}'" class="rounded-lg overflow-hidden border hover:border-orange-500 transition">
                    <img src="{{ $producto->imagen3 }}" class="h-24 w-full object-cover">
                </button>
            </div>
        </div>

        <div class="flex flex-col justify-center">
            <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $producto->nombre }}</h1>
            <p class="text-gray-500 text-lg mb-6 leading-relaxed">{{ $producto->detalles }}</p>
            
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-baseline mb-4">
                    <span class="text-4xl font-bold text-orange-600">${{ number_format($producto->precio, 2) }}</span>
                </div>
                
                {{-- Lógica de Disponibilidad basada en Status --}}
                <div class="mb-6">
                    @if($producto->status == 'activo')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                            Disponible ahora
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                            No disponible temporalmente
                        </span>
                    @endif
                </div>

                {{-- Botón Condicional --}}
                @if($producto->status == 'activo')
                    <button class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold hover:bg-black transition shadow-lg">
                        Agregar al pedido
                    </button>
                @else
                    <button disabled class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed">
                        Agotado
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection