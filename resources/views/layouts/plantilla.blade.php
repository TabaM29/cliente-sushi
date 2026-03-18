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
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li><a href="{{ route('inicio') }}" class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600">Inicio</a></li>
                    <li><a href="{{ route('nosotros') }}" class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600">Nosotros</a></li>
                    <li><a href="{{ route('catalogo') }}" class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600">Catálogo</a></li>
                    <li><a href="{{ route('contacto.index') }}" class="block py-2 pr-4 pl-3 text-gray-700 hover:text-orange-600">Contacto</a></li>
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