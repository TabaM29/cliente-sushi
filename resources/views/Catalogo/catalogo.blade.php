@extends('layouts.plantilla')

@section('content')
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <h2 class="mb-12 text-4xl font-extrabold text-gray-900 text-center">Nuestro <span class="text-orange-600">Menú</span>
        </h2>

        @foreach ($categorias as $nombreCategoria => $platillos)
            <div class="flex items-center my-8">
                <h3 class="text-2xl font-bold text-gray-800 pr-4">{{ $nombreCategoria }}</h3>
                <div class="flex-grow h-px bg-gray-200"></div>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mb-16">
                @foreach ($platillos as $p)
                    {{-- Evaluamos si el producto no tiene stock o está inactivo --}}
                    @php $estaAgotado = ($p->stock <= 0 || $p->status != 'activo'); @endphp

                    <div
                        class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all {{ $estaAgotado ? 'opacity-75' : '' }}">
                        <div class="relative">
                            {{-- Aplicamos escala de grises si está agotado --}}
                            <img class="rounded-t-2xl h-48 w-full object-cover {{ $estaAgotado ? 'grayscale' : '' }}"
                                src="{{ $p->imagen1 }}" alt="{{ $p->nombre }}">

                            @if ($estaAgotado)
                                <div class="absolute inset-0 bg-black/20 rounded-t-2xl flex items-center justify-center">
                                    <span
                                        class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                        Agotado
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h5 class="text-lg font-bold {{ $estaAgotado ? 'text-gray-500' : 'text-gray-900' }} mb-2">
                                {{ $p->nombre }}
                            </h5>

                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold {{ $estaAgotado ? 'text-gray-400' : 'text-orange-600' }}">
                                    ${{ number_format($p->precio, 2) }}
                                </span>

                                {{-- Si está agotado, podemos cambiar el estilo del botón o deshabilitarlo --}}
                                @if ($estaAgotado)
                                    <span class="text-gray-400 text-sm font-medium italic">No disponible</span>
                                @else
                                    <a href="{{ route('detalle', $p->id) }}"
                                        class="text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition">
                                        Detalles →
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
