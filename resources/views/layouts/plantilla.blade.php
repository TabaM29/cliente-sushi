<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SushiZen - Cliente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

    <nav class="bg-white border-b border-gray-200 px-4 py-2.5">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="{{ route('inicio') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap text-orange-600">SushiZen</span>
            </a>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 items-center">
                    <li>
                        <a href="{{ route('inicio') }}"
                            class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600 transition-colors">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('nosotros') }}"
                            class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600 transition-colors">Nosotros</a>
                    </li>
                    <li>
                        <a href="{{ route('catalogo') }}"
                            class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600 transition-colors">Catálogo</a>
                    </li>
                    <li>
                        <a href="{{ route('contacto.index') }}"
                            class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600 transition-colors">Contacto</a>
                    </li>

                    <li class="ml-4">
                        <a href="{{ route('carrito.index') }}"
                            class="relative group p-2 flex items-center justify-center rounded-full hover:bg-orange-50 transition-all">
                            <svg class="w-7 h-7 text-gray-700 group-hover:text-orange-600 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>

                            @if (count(session('carrito', [])) > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-orange-600 text-white text-[10px] font-bold h-5 w-5 flex items-center justify-center rounded-full shadow-sm">
                                    {{ count(session('carrito', [])) }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    <footer class="p-4 bg-gray-50 sm:p-6 border-t mt-10">
        <div class="mx-auto max-w-screen-xl text-center">
            <span class="text-sm text-gray-500">© 2026 SushiZen. Todos los derechos reservados.</span>
        </div>
    </footer>

</body>

</html>
