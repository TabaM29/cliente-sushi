@extends('layouts.plantilla')

@section('content')
    <div class="flex items-center justify-center min-h-screen py-12 px-4 bg-gray-50">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

            <div class="h-40 bg-orange-600 w-full relative">
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2 text-center">
                    <div class="relative inline-block group">
                        <img src="{{ $cliente->foto }}"
                            class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-xl bg-white"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($cliente->nombres) }}&background=fed7aa&color=ea580c'">

                        <form action="{{ route('perfil.updateFoto') }}" method="POST" enctype="multipart/form-data"
                            id="form-foto" class="absolute bottom-0 right-0">
                            @csrf
                            <label for="foto-input"
                                class="bg-gray-900 text-white p-2 rounded-full cursor-pointer hover:bg-orange-600 transition-colors shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </label>
                            <input type="file" name="foto" id="foto-input" class="hidden"
                                onchange="document.getElementById('form-foto').submit()">
                        </form>
                    </div>
                    <h2 class="mt-2 text-2xl font-black text-gray-800">{{ $cliente->nombres }}</h2>
                    <p class="text-orange-600 font-bold text-xs uppercase tracking-widest">Cliente Premium</p>
                </div>
            </div>

            <div class="pt-20 pb-10 px-8">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm font-bold rounded-r-xl animate-pulse">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex border-b border-gray-100 mb-8">
                    <button onclick="switchTab('info')" id="tab-info"
                        class="tab-btn px-6 py-3 font-bold text-orange-600 border-b-2 border-orange-600 transition-all">Mi
                        Información</button>
                    <button onclick="switchTab('seguridad')" id="tab-seguridad"
                        class="tab-btn px-6 py-3 font-bold text-gray-400 hover:text-gray-600 transition-all">Seguridad</button>
                </div>

                <div id="content-info" class="tab-content space-y-6">
                    <form action="{{ route('perfil.updateDatos') }}" method="POST" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Nombre(s)</label>
                                <input type="text" name="nombres" value="{{ old('nombres', $cliente->nombres) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium">
                                @error('nombres')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno"
                                    value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Apellido Materno</label>
                                <input type="text" name="apellido_materno"
                                    value="{{ old('apellido_materno', $cliente->apellido_materno) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Correo Electrónico</label>
                                <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium">
                                @error('correo')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full py-4 bg-orange-600 text-white rounded-2xl font-bold hover:bg-orange-700 transition-all shadow-lg shadow-orange-200">
                            Guardar Cambios
                        </button>
                    </form>
                </div>

                <div id="content-seguridad" class="tab-content hidden space-y-6">
                    <form action="{{ route('perfil.updatePassword') }}" method="POST" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase">Contraseña Actual</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium pr-12">
                                <button type="button" onclick="togglePass('current_password', 'eye_current')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600">
                                    <svg id="eye_current" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Nueva Contraseña</label>
                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password"
                                        class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium pr-12">
                                    <button type="button" onclick="togglePass('new_password', 'eye_new')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600">
                                        <svg id="eye_new" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('new_password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-400 uppercase">Confirmar Nueva Contraseña</label>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 font-medium pr-12">
                                    <button type="button" onclick="togglePass('new_password_confirmation', 'eye_confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600">
                                        <svg id="eye_confirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-black transition-all shadow-lg shadow-gray-200">
                            Actualizar Contraseña
                        </button>
                    </form>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('catalogo') }}"
                        class="text-sm font-bold text-gray-400 hover:text-orange-600 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Menú
                    </a>
                    <form action="{{ route('logout.cliente') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm font-bold text-red-400 hover:text-red-600 transition-colors">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('text-orange-600', 'border-orange-600', 'border-b-2');
                b.classList.add('text-gray-400');
            });

            document.getElementById('content-' + tab).classList.remove('hidden');
            
            const btn = document.getElementById('tab-' + tab);
            btn.classList.add('text-orange-600', 'border-orange-600', 'border-b-2');
            btn.classList.remove('text-gray-400');
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->has('current_password') || $errors->has('new_password'))
                switchTab('seguridad');
            @endif
        });

        function togglePass(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            if (isPassword) {
                eye.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                eye.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
@endsection