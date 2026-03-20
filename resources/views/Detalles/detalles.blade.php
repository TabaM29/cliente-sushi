@extends('layouts.plantilla')

@section('content')
    @php $producto = (object) $producto; @endphp

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- Sección de Imágenes --}}
            <div class="space-y-4">
                <div class="relative h-96 overflow-hidden rounded-2xl shadow-lg border">
                    <img id="current-img" src="{{ $producto->imagen1 }}" class="w-full h-full object-cover">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    @if(isset($producto->imagen1))
                    <button onclick="document.getElementById('current-img').src='{{ $producto->imagen1 }}'"
                        class="rounded-lg overflow-hidden border hover:border-orange-500 transition focus:ring-2 focus:ring-orange-500">
                        <img src="{{ $producto->imagen1 }}" class="h-24 w-full object-cover">
                    </button>
                    @endif
                    @if(isset($producto->imagen2))
                    <button onclick="document.getElementById('current-img').src='{{ $producto->imagen2 }}'"
                        class="rounded-lg overflow-hidden border hover:border-orange-500 transition focus:ring-2 focus:ring-orange-500">
                        <img src="{{ $producto->imagen2 }}" class="h-24 w-full object-cover">
                    </button>
                    @endif
                    @if(isset($producto->imagen3))
                    <button onclick="document.getElementById('current-img').src='{{ $producto->imagen3 }}'"
                        class="rounded-lg overflow-hidden border hover:border-orange-500 transition focus:ring-2 focus:ring-orange-500">
                        <img src="{{ $producto->imagen3 }}" class="h-24 w-full object-cover">
                    </button>
                    @endif
                </div>
            </div>

            {{-- Sección de Información y Botones --}}
            <div class="flex flex-col justify-center">
                <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $producto->nombre }}</h1>
                <p class="text-gray-500 text-lg mb-6 leading-relaxed">{{ $producto->detalles }}</p>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-baseline mb-4">
                        <span class="text-4xl font-bold text-orange-600">${{ number_format($producto->precio, 2) }}</span>
                    </div>

                    {{-- Lógica de Disponibilidad basada en Status --}}
                    <div class="mb-6">
                        @if ($producto->status == 'activo')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Disponible ahora
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                Agotado temporalmente
                            </span>
                        @endif
                    </div>

                    {{-- Panel de Acciones Condicional --}}
                    @if ($producto->status == 'activo')
                        <div class="space-y-3">
                            {{-- 1. Botón de Agregar al Carrito (Formulario) --}}
                            <form action="{{ route('carrito.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $producto->id }}">
                                <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                                <input type="hidden" name="precio" value="{{ $producto->precio }}">
                                <input type="hidden" name="imagen" value="{{ $producto->imagen1 }}">

                                <button type="submit" class="w-full bg-orange-600 text-white px-6 py-4 rounded-xl font-bold text-lg hover:bg-orange-700 transition-all flex justify-center items-center gap-2 shadow-md hover:shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Agregar al Carrito
                                </button>
                            </form>

                            {{-- Botones Secundarios --}}
                            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                                {{-- 2. Botón Continuar a Compra (Ir al carrito) --}}
                                <a href="{{ route('carrito.index') }}" class="flex-1 bg-gray-900 text-white text-center px-4 py-3 rounded-xl font-bold hover:bg-gray-800 transition-colors flex justify-center items-center gap-2">
                                    Continuar a compra
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>

                                {{-- 3. Botón Agregar más productos (Ir al catálogo) --}}
                                <a href="{{ route('catalogo') }}" class="flex-1 bg-white border-2 border-orange-200 text-orange-600 text-center px-4 py-3 rounded-xl font-bold hover:bg-orange-50 hover:border-orange-500 transition-colors">
                                    Ver más platillos
                                </a>
                            </div>
                        </div>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed">
                            Agotado
                        </button>
                        <div class="mt-4 text-center">
                            <a href="{{ route('catalogo') }}" class="text-orange-600 font-bold hover:underline">
                                Ver opciones similares
                            </a>
                        </div>
                    @endif
                </div>
                
                {{-- Mensaje de éxito si se acaba de agregar --}}
                @if(session('success'))
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection