@extends('layouts.plantilla')

@section('content')
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-gray-800">Crea tu cuenta</h2>
                <p class="text-gray-500 mt-2">Únete a la experiencia <span class="text-orange-600 font-bold">SushiZen</span>
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('registro.cliente.post') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 bg-white rounded-3xl shadow-lg">
                @csrf

                <input type="text" name="nombres" placeholder="Nombres" required class="border p-3 rounded-xl">
                <input type="text" name="apellido_paterno" placeholder="Apellido Paterno" required
                    class="border p-3 rounded-xl">

                <input type="text" name="apellido_materno" placeholder="Apellido Materno" required
                    class="border p-3 rounded-xl">
                <input type="text" name="telefono" placeholder="Teléfono" required class="border p-3 rounded-xl">

                <div>
                    <label class="block text-sm front-bold mb-1"> Fecha de nacimiento</label>
                    <input type="date" name="fecha_nac" required class="border p-3 rounded-xl md:col-span-2">
                </div>

                <input type="email" name="correo" placeholder="Correo electrónico" required
                    class="border p-3 rounded-xl md:col-span-2">

                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Contraseña" required
                        class="w-full border p-3 pr-12 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                    <button type="button" onclick="togglePass('password', 'eye1')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600">
                        <svg id="eye1" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirmar Contraseña" required
                        class="w-full border p-3 pr-12 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                    <button type="button" onclick="togglePass('password_confirmation', 'eye2')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600">
                        <svg id="eye2" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold mb-1">Foto de Perfil</label>
                    <input type="file" name="foto" accept="image/jpeg" class="w-full">
                </div>

                <button type="submit"
                    class="md:col-span-2 bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition-all">
                    Crear cuenta
                </button>
            </form>

            <div class="mt-8 text-center">

                <div class="mt-8 text-center border-t pt-6">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login.cliente') }}" class="font-bold text-orange-600 hover:underline">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <script>
    function togglePass(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        if (isPassword) {
            // Icono Ojo Tachado (Ocultar)
            eye.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            // Icono Ojo Normal (Ver)
            eye.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
</script>
    @endsection
