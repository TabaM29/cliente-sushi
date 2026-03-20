@extends('layouts.plantilla')

@section('content')
<div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
    <h2 class="mb-12 text-4xl font-extrabold text-gray-900 text-center">Nuestro <span class="text-orange-600">Menú</span></h2>

    @foreach($categorias as $nombreCategoria => $platillos)
        {{-- Título de la Categoría --}}
        <div class="flex items-center my-8">
            <h3 class="text-2xl font-bold text-gray-800 pr-4">{{ $nombreCategoria }}</h3>
            <div class="flex-grow h-px bg-gray-200"></div>
        </div>

        {{-- Grid de Platillos para esta categoría --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mb-16">
            @foreach($platillos as $p)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all">
                    <div class="relative">
                        <img class="rounded-t-2xl h-48 w-full object-cover" src="{{ $p->imagen1 }}" alt="{{ $p->nombre }}">
                        
                        @if($p->status != 'activo')
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-md">Agotado</div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <h5 class="text-lg font-bold text-gray-900 mb-2">{{ $p->nombre }}</h5>
                        
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-orange-600">${{ number_format($p->precio, 2) }}</span>
                            
                            {{-- Botón de detalles --}}
                            <a href="{{ route('detalle', $p->id) }}" class="text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition">
                                Detalles →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection