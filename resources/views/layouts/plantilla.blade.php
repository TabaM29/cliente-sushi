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

                    {{-- Ícono del Carrito (Visible para todos) --}}
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

                    {{-- LÓGICA DE AUTENTICACIÓN --}}
                    <li class="ml-4 border-l border-gray-200 pl-6 flex items-center gap-4">
                        @if (session()->has('cliente_token'))
                            {{-- ==========================================
                                 ESTO SOLO LO VEN LOS CLIENTES LOGUEADOS 
                                 ========================================== --}}
                            
                            {{-- Enlace a Mis Pedidos --}}
                            <a href="{{ route('pedidos.index') }}" 
                               class="flex items-center gap-1 text-gray-700 hover:text-orange-600 transition-colors font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Mis Pedidos</span>
                            </a>

                            {{-- Perfil del Usuario --}}
                            <a href="{{ route('perfil.index') }}"
                                class="flex items-center gap-2 text-gray-700 hover:text-orange-600 transition-colors font-medium ml-2">
                                @if (session()->has('cliente_data') && !empty(session('cliente_data')['foto']))
                                    @php
                                        $fotoUrl = session('cliente_data')['foto'];
                                        $pathLimpio = str_replace('storage/', '', $fotoUrl);
                                        if (!str_starts_with($fotoUrl, 'http')) {
                                            $fotoUrl = 'http://127.0.0.1:8000/storage/' . $pathLimpio;
                                        }
                                    @endphp
                                    <img src="{{ $fotoUrl }}"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-200"
                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('cliente_data')['nombres']) }}&background=fed7aa&color=ea580c'">
                                @endif
                                <span>{{ session('cliente_data')['nombres'] ?? 'Mi Perfil' }}</span>
                            </a>

                            {{-- Cerrar sesión --}}
                            <form action="{{ route('logout.cliente') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors">
                                    Salir
                                </button>
                            </form>

                        @else
                            {{-- ==========================================
                                 ESTO LO VEN LOS INVITADOS (NO LOGUEADOS)
                                 ========================================== --}}
                            <a href="{{ route('login.cliente') }}"
                                class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('registro.cliente') }}"
                                class="bg-orange-600 text-white px-5 py-2 rounded-full font-bold hover:bg-orange-700 transition-all shadow-sm">
                                Registrarse
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pt-10">
        @yield('content')
    </main>

    <footer class="p-4 bg-gray-50 sm:p-6 border-t mt-10">
        <div class="mx-auto max-w-screen-xl text-center">
            <span class="text-sm text-gray-500">© 2026 SushiZen. Todos los derechos reservados.</span>
        </div>
    </footer>

</body>

</html>