<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatalogoController extends Controller
{
    // Definimos la URL base de tu API (Puerto 8000)
    protected $url = "http://127.0.0.1:8000/api/platillos";

    /**
     * Muestra el catálogo completo
     */
    // app/Http/Controllers/ClienteController.php

public function index()
{
    $response = Http::get("http://127.0.0.1:8000/api/platillos");

    if ($response->successful()) {
        $body = json_decode($response->body());
        $platillosApi = $body->data->platillos;

        $categorias = collect($platillosApi)->groupBy(function($item) {
            // Buscamos 'nombre_categoria' que es el nombre real en tu API
            if (isset($item->categoria) && isset($item->categoria->nombre_categoria)) {
                return $item->categoria->nombre_categoria;
            }
            return 'Especialidades';
        });

        return view('Catalogo.catalogo', compact('categorias'));
    }

    return "Error al conectar con la API";
}
public function show($id)
{
    $response = Http::get("http://127.0.0.1:8000/api/platillos/" . $id);

    if ($response->successful()) {
        $body = json_decode($response->body());
        
        // Verificamos si la API dice que el resultado es true
        if($body->resultado) {
            $producto = $body->data->platillo; // data -> platillo
            return view('Detalles.detalles', compact('producto'));
        }
    }

    return redirect()->route('catalogo')->with('error', 'No se encontró el platillo');
}
}