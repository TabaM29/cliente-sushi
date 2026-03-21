<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerfilController extends Controller
{
    // URL base de tu API para el perfil
    protected $url = 'http://127.0.0.1:8000/api/cliente/perfil';

    private function getAuth()
    {
        $token = session('cliente_token');
        return Http::withToken($token)->acceptJson();
    }

    /**
     * 1. Mostrar la vista del perfil
     */
    public function index()
    {
        $response = $this->getAuth()->get($this->url);

        if ($response->failed()) {
            return redirect('/')->with('error', 'No se pudo cargar tu perfil.');
        }

        $cliente = (object) $response->json();

        // Normalizar la URL de la foto para la vista
        if (isset($cliente->foto) && !empty($cliente->foto)) {
            if (!str_starts_with($cliente->foto, 'http')) {
                $path = str_replace('storage/', '', $cliente->foto);
                $cliente->foto = 'http://127.0.0.1:8000/storage/' . $path;
            }
        }

        return view('auth.perfil', compact('cliente'));
    }

    /**
     * 2. Actualizar datos generales
     */
    public function updateDatos(Request $request)
    {
        // IMPORTANTE: Quitamos el {$id} de la URL porque la API usa el Token (auth:clientes)
        $response = $this->getAuth()->put($this->url . '/datos', [
            'nombres'          => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno, // Enviamos este aunque sea nulo
            'telefono'         => $request->telefono,
            'correo'           => $request->correo,
        ]);

        if ($response->successful()) {
            $res = $response->json();
            $clienteActualizado = $res['data']['cliente'] ?? $res['cliente'];
            session(['cliente_data' => $clienteActualizado]);

            return back()->with('success', '¡Información actualizada correctamente!');
        }

        $errores = $response->json()['errores'] ?? [];
        return back()->withErrors($errores)->withInput();
    }

    /**
     * 3. Actualizar Foto de Perfil
     */
    public function updateFoto(Request $request)
    {
        if (!$request->hasFile('foto')) {
            return back()->with('error', 'Selecciona una imagen.');
        }

        $foto = $request->file('foto');

        $response = $this->getAuth()
            ->attach('foto', file_get_contents($foto->getRealPath()), $foto->getClientOriginalName())
            ->post($this->url . '/foto');

        if ($response->successful()) {
            $res = $response->json();
            $data = session('cliente_data');
            
            $nuevaFoto = $res['data']['foto'] ?? $res['foto'];
            $data['foto'] = $nuevaFoto;
            
            session(['cliente_data' => $data]);

            return back()->with('success', 'Foto de perfil actualizada.');
        }

        return back()->with('error', 'Error al subir la imagen.');
    }

    /**
     * 4. Actualizar Contraseña
     */
    public function updatePassword(Request $request)
    {
        // La ruta en la API es /cliente/perfil/password
        $response = $this->getAuth()->put($this->url . '/password', [
            'current_password'      => $request->current_password,
            'password'              => $request->new_password,
            'password_confirmation' => $request->new_password_confirmation,
        ]);

        if ($response->successful()) {
            return back()->with('success', '¡Contraseña actualizada con éxito!');
        }

        $res = $response->json();
        // Si la contraseña actual está mal, la API devuelve error 403 con mensaje en 'errores'
        $errores = $res['errores'] ?? ['current_password' => [$res['mensaje'] ?? 'Error']];

        return back()->withErrors($errores);
    }
}