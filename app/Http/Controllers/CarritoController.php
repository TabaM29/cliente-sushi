<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarritoController extends Controller
{
    // URL base de tu API
    private $apiUrl = 'http://127.0.0.1:8000/api';

    // Ver el contenido del carrito
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    // Agregar producto al carrito
    public function add(Request $request)
    {
        $id = $request->id;
        $carrito = session()->get('carrito', []);

        $response = Http::get("{$this->apiUrl}/platillos/{$id}");
        
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'No se pudo verificar el stock del producto.');
        }

        $platilloData = $response->json()['data']['platillo'] ?? $response->json()['data'];
        $stockDisponible = $platilloData['stock'];

        $cantidadActual = isset($carrito[$id]) ? $carrito[$id]['cantidad'] : 0;
        $nuevaCantidad = $cantidadActual + 1;

        if ($nuevaCantidad > $stockDisponible) {
            return redirect()->back()->with('error', "No hay suficiente stock. Solo quedan {$stockDisponible} unidades de {$platilloData['nombre']}.");
        }

        if(isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "nombre" => $request->nombre,
                "cantidad" => 1,
                "precio" => $request->precio,
                "imagen" => $request->imagen
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request)
    {
        if($request->id && $request->cantidad){
            $id = $request->id;
            $nuevaCantidad = $request->cantidad;

            $response = Http::get("{$this->apiUrl}/platillos/{$id}");
            
            if ($response->successful()) {
                $platilloData = $response->json()['data']['platillo'] ?? $response->json()['data'];
                $stockDisponible = $platilloData['stock'];

                if ($nuevaCantidad > $stockDisponible) {
                    return redirect()->back()->with('error', "No puedes agregar {$nuevaCantidad}. Solo quedan {$stockDisponible} en stock.");
                }
            }

            $carrito = session()->get('carrito');
            $carrito[$id]["cantidad"] = $nuevaCantidad;
            session()->put('carrito', $carrito);
            
            return redirect()->back()->with('success', 'Carrito actualizado');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $carrito = session()->get('carrito');
            if(isset($carrito[$request->id])) {
                unset($carrito[$request->id]);
                session()->put('carrito', $carrito);
            }
            return redirect()->back()->with('success', 'Producto eliminado');
        }
    }

    // Vaciar carrito
    public function clear()
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }

    public function checkout()
    {
        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        $total = 0;
        $productosParaEnviar = [];

        foreach ($carrito as $id => $detalles) {
            $total += $detalles['precio'] * $detalles['cantidad'];
            $productosParaEnviar[] = [
                'platillo_id' => $id,
                'cantidad' => $detalles['cantidad'],
                'precio_unitario' => $detalles['precio']
            ];
        }

        $token = session('cliente_token'); 

        $response = Http::withToken($token)
            ->post("{$this->apiUrl}/pedidos", [
                'total' => $total,
                'productos' => $productosParaEnviar
            ]);

        if ($response->successful()) {
            session()->forget('carrito'); 
            return redirect()->route('mis_pedidos.index')->with('success', '¡Pedido confirmado!');
        }

        return redirect()->back()->with('error', 'Hubo un error al procesar el pedido.');
    }
}