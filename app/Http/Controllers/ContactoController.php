<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactoController extends Controller
{
    protected $url = "http://127.0.0.1:8000/api/contacto";

    public function index()
    {
        return view('Contacto.contacto'); 
    }

    public function store(Request $request)
{
    $response = Http::post($this->url, $request->all());

    // Esto te mostrará el error real que devuelve la API
    if ($response->failed()) {
        dd([
            'Codigo_Status' => $response->status(),
            'Error_API' => $response->json(),
            'Datos_Enviados' => $request->all()
        ]);
    }

    return redirect()->route('contacto.index')->with('success', 'Enviado');
}
}