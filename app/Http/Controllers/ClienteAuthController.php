<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteAuthController extends Controller
{
    protected $url = "http://127.0.0.1:8000/api";

    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Muestra el formulario de registro
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Procesa el Inicio de Sesión
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::post($this->url . '/cliente/login', [
            'correo' => $request->correo,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            session([
                'cliente_token' => $data['token'],
                'cliente_data' => $data['cliente']
            ]);

            return redirect()->route('catalogo')->with('success', '¡Bienvenido de nuevo!');
        }

        return back()->withErrors(['error' => 'Correo o contraseña incorrectos']);
    }

    /**
     * Procesa el Registro de un nuevo cliente
     */
    public function register(Request $request) 
{
    $url = "http://127.0.0.1:8000/api/cliente/registro";

    $peticion = Http::asMultipart();

    if ($request->hasFile('foto')) {
        $peticion->attach('foto', file_get_contents($request->file('foto')), $request->file('foto')->getClientOriginalName());
    }

    $response = $peticion->post($url, $request->except('foto'));

    if ($response->successful()) {
        return redirect()->route('login.cliente')->with('success', '¡Cuenta creada! Ya puedes iniciar sesión.');
    }

    return back()->withErrors($response->json())->withInput();
}

    /**
     * Muestra el perfil del cliente (Ruta Protegida)
     */
    public function perfil() 
{
    $token = session('cliente_token');

    if (!$token) {
        return redirect()->route('login.cliente')->with('error', 'Debes iniciar sesión para ver tu perfil');
    }

    $response = Http::withToken($token)->get($this->url . '/cliente/perfil');

    if ($response->successful()) {
        $cliente = $response->json();

        if (!empty($cliente['foto'])) {
            $apiStorageUrl = "http://127.0.0.1:8000/storage/"; 
            $cliente['foto'] = $apiStorageUrl . $cliente['foto'];
        }

        return view('auth.perfil', compact('cliente'));
    }

    session()->forget(['cliente_token', 'cliente_data']);
    return redirect()->route('login.cliente')->withErrors(['error' => 'Tu sesión ha expirado']);
}

    /**
     * Cierra la sesión
     */
    public function logout()
    {
        $token = session('cliente_token');

        if ($token) {
            Http::withToken($token)->post($this->url . '/cliente/logout');
        }

        session()->forget(['cliente_token', 'cliente_data']);

        return redirect()->route('login.cliente')->with('success', 'Has cerrado sesión correctamente');
    }


}