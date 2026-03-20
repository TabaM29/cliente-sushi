<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
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
        $carrito = session()->get('carrito', []);

        $id = $request->id;

        // Si el producto ya está, aumentamos cantidad
        if(isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            // Si es nuevo, lo agregamos con los datos enviados
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

    // Actualizar cantidad
    public function update(Request $request)
    {
        if($request->id && $request->cantidad){
            $carrito = session()->get('carrito');
            $carrito[$request->id]["cantidad"] = $request->cantidad;
            session()->put('carrito', $carrito);
            return redirect()->back()->with('success', 'Carrito actualizado');
        }
    }

    // Eliminar un producto
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
}