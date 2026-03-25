@extends('layouts.plantilla')

@section('content')
    @php
        $producto = (object) $producto;
        $estaDisponible = $producto->status == 'activo' && $producto->stock > 0;
    @endphp

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        {{-- Migajas de pan para navegación --}}
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="{{ route('catalogo') }}" class="hover:text-orange-600">Menú</a>
            <span class="mx-2">/</span>
            <span class="font-bold text-gray-900">{{ $producto->nombre }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Sección de Imágenes --}}
            <div class="space-y-4">
                <div class="relative aspect-square overflow-hidden rounded-3xl shadow-lg border-4 border-white">
                    <img id="current-img" src="{{ $producto->imagen1 }}"
                        class="w-full h-full object-cover transition-all duration-500 {{ !$estaDisponible ? 'grayscale opacity-70' : '' }}">

                    @if (!$estaDisponible)
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span
                                class="bg-white text-red-600 font-black px-8 py-3 rounded-full shadow-2xl uppercase tracking-tighter text-xl">
                                Agotado
                            </span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-4">
                    @for ($i = 1; $i <= 3; $i++)
                        @php $imgField = "imagen$i"; @endphp
                        @if (isset($producto->$imgField))
                            <button onclick="document.getElementById('current-img').src='{{ $producto->$imgField }}'"
                                class="rounded-2xl overflow-hidden border-2 border-transparent hover:border-orange-500 transition focus:ring-4 focus:ring-orange-200">
                                <img src="{{ $producto->$imgField }}"
                                    class="h-24 w-full object-cover {{ !$estaDisponible ? 'grayscale' : '' }}">
                            </button>
                        @endif
                    @endfor
                </div>
            </div>

            {{-- Sección de Información --}}
            <div class="flex flex-col">
                <div class="mb-4">
                    @if ($estaDisponible)
                        <span
                            class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Platillo
                            Popular</span>
                    @endif
                </div>

                <h1 class="text-5xl font-black text-gray-900 mb-4 tracking-tight">
                    {{ $producto->nombre }}
                </h1>

                <p class="text-gray-600 text-xl mb-8 leading-relaxed">{{ $producto->detalles }}</p>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Precio Unitario</p>
                            <span
                                class="text-5xl font-black text-orange-600">${{ number_format($producto->precio, 2) }}</span>
                        </div>
                        <div class="text-right">
                            @if ($estaDisponible)
                                <p class="text-sm text-green-600 font-bold italic">¡En Stock!</p>
                                <p class="text-xs text-gray-400">{{ $producto->stock }} unidades disponibles</p>
                            @endif
                        </div>
                    </div>

                    @if ($estaDisponible)
                        <form action="{{ route('carrito.add') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id }}">
                            <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                            <input type="hidden" name="precio" value="{{ $producto->precio }}">
                            <input type="hidden" name="imagen" value="{{ $producto->imagen1 }}">

                            {{-- Botón Principal --}}
                            <button type="submit"
                                class="w-full bg-orange-600 text-white px-6 py-5 rounded-2xl font-black text-xl hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all flex justify-center items-center gap-3 shadow-xl shadow-orange-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Agregar a la orden
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 p-6 rounded-2xl text-center">
                            <p class="text-gray-500 font-bold mb-4">Este producto no está disponible por el momento.</p>
                            <a href="{{ route('catalogo') }}"
                                class="text-orange-600 font-black hover:underline underline-offset-4">
                                VER OTROS PLATILLOS →
                            </a>
                        </div>
                    @endif

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('catalogo') }}"
                            class="flex-1 text-center py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition">Volver
                            al Menú</a>
                        @if (session('carrito'))
                            <a href="{{ route('carrito.index') }}"
                                class="flex-1 text-center py-3 text-sm font-bold text-orange-600 bg-orange-50 rounded-xl hover:bg-orange-100 transition">Ver
                                mi Carrito</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
