@extends('layouts.plantilla') {{-- Ajustado a tu layout principal --}}

@section('content')
<div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-base font-semibold text-orange-600 uppercase tracking-wide">Contacto</h2>
            <p class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                ¡Hablemos de Sushi!
            </p>
        </div>

        <div class="bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contacto.store') }}" method="POST" class="grid grid-cols-1 gap-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input type="text" name="nombre" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-4 py-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" required 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 px-4 py-3">
                        </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Asunto</label>
                        <input type="text" name="asunto" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-4 py-3">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tu mensaje</label>
                    <textarea name="mensaje" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-4 py-3"></textarea>
                </div>

                <button type="submit" class="w-full py-4 px-6 border border-transparent shadow-sm text-lg font-bold rounded-md text-white bg-orange-600 hover:bg-orange-700 transition-colors">
                    Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</div>
@endsection