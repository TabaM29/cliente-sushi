@extends('layouts.plantilla')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
        <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
            <h2 class="mb-4 text-4xl font-extrabold text-gray-900 dark:text-white">Sobre <span class="text-orange-600">SushiZen</span></h2>
            <p class="mb-4">Nacimos de la pasión por la cocina japonesa tradicional fusionada con ingredientes locales frescos.</p>
            <p>Nuestra misión es ofrecer una experiencia culinaria única, donde cada rollo de sushi cuenta una historia de frescura, calidad y arte. No solo servimos comida, creamos momentos memorables para tu paladar.</p>
            
            <div class="grid grid-cols-2 gap-4 mt-8">
                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-orange-600">
                    <p class="text-2xl font-bold text-gray-900">100%</p>
                    <p class="text-sm text-gray-500">Frescura garantizada</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-orange-600">
                    <p class="text-2xl font-bold text-gray-900">+10</p>
                    <p class="text-sm text-gray-500">Años de experiencia</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-8">
            <img class="w-full rounded-lg shadow-md" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-2.png" alt="Preparación de sushi 1">
            <img class="mt-4 w-full lg:mt-10 rounded-lg shadow-md" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-1.png" alt="Nuestro restaurante">
        </div>
    </div>
</section>

<section class="bg-gray-50 dark:bg-gray-800 py-12">
    <div class="max-w-screen-xl px-4 mx-auto text-center">
        <h3 class="text-2xl font-bold mb-8">Nuestros Pilares</h3>
        <div class="grid gap-8 md:grid-cols-3">
            <div class="p-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h4 class="text-xl font-bold mb-2">Calidad Premium</h4>
                <p class="text-gray-500">Seleccionamos el mejor pescado cada mañana en el mercado central.</p>
            </div>
            <div class="p-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3"></path></svg>
                </div>
                <h4 class="text-xl font-bold mb-2">Rapidez</h4>
                <p class="text-gray-500">Tu pedido listo y fresco en la puerta de tu casa en menos de 40 minutos.</p>
            </div>
            <div class="p-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-xl font-bold mb-2">Sabor Único</h4>
                <p class="text-gray-500">Recetas secretas en nuestra salsa de soya y arroz perfectamente sazonado.</p>
            </div>
        </div>
    </div>
</section>

@endsection