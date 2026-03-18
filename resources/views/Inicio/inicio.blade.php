@extends('layouts.plantilla')

@section('content')
<section class="bg-white dark:bg-gray-900 flex items-center justify-center">
    <div class="grid max-w-screen-xl px-6 py-12 mx-auto lg:gap-8 xl:gap-0 lg:py-24 lg:grid-cols-12">
        
        <div class="mr-auto place-self-center lg:col-span-7">
            <h1 class="max-w-2xl mb-6 text-4xl font-extrabold tracking-tight leading-tight md:text-5xl xl:text-6xl dark:text-white">
                El mejor Sushi <br> <span class="text-orange-600">en la puerta de tu casa.</span>
            </h1>
            <p class="max-w-2xl mb-8 font-light text-gray-500 lg:mb-10 md:text-lg lg:text-xl dark:text-gray-400">
                Desde rolls tradicionales hasta creaciones de autor. Descubre por qué somos la opción favorita de la ciudad.
            </p>
            
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <a href="{{ route('catalogo') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white rounded-lg bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:ring-orange-300">
                    Ver Menú
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
                <a href="{{ route('contacto.index') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100">
                    Contáctanos
                </a>
            </div>
        </div>

        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex justify-end">
            <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&q=80&w=1000" 
                alt="Sushi Hero"
                class="rounded-2xl shadow-2xl object-cover h-full w-full max-h-[500px]">
        </div>
    </div>
</section>
@endsection