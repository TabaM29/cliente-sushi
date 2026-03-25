<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidosController extends Controller
{
    // MUESTRA LA VISTA DE RESUMEN
    public function checkout()
    {
        $carrito = session()->get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = 0;
        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('pedidos.pedido', compact('carrito', 'total'));
    }

public function store(Request $request)
{
    $carrito = session()->get('carrito', []);
    $token = session('cliente_token'); 

    if (empty($carrito)) {
        return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
    }

    // 1. Preparar datos
    $total = 0;
    $productos = [];
    foreach ($carrito as $id => $detalles) {
        $total += $detalles['precio'] * $detalles['cantidad'];
        $productos[] = [
            'platillo_id'      => $id,
            'cantidad'         => $detalles['cantidad'],
            'precio_unitario'  => $detalles['precio']
        ];
    }

    $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/pedidos', [
        'total'     => $total,
        'productos' => $productos
    ]);

    if ($response->successful()) {
    $resumen = session('carrito'); // Guardamos una copia antes de borrar
    $totalPagado = $total; // La variable total que calculaste

    session()->forget('carrito');
    
    // Pasamos el resumen a la redirección
    return redirect()->route('pedidos.exito')->with([
        'resumen' => $resumen,
        'totalPagado' => $totalPagado
    ]);
}

    return back()->with('error', 'Error en la API: ' . $response->json()['mensaje']);
}

    public function exito()
    {
        return view('pedidos.exito');
    }

    public function index() {
    $token = session('cliente_token');
    
    $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/pedidos');
    
    $pedidos = $response->json()['data'] ?? [];
    return view('pedidos.index', compact('pedidos'));
}

public function show($id)
{
    $token = session('cliente_token');
    
    $resPedido = Http::withToken($token)->get("http://127.0.0.1:8000/api/pedidos/{$id}");
    $jsonPedido = $resPedido->json();

    $pedido = $jsonPedido['data']['pedido'] ?? null;

    if (!$pedido) {
        return redirect()->route('pedidos.index')->with('error', 'No se encontró el pedido');
    }

    $resPlatillos = Http::get("http://127.0.0.1:8000/api/platillos");
    $jsonPlatillos = $resPlatillos->json();
    
    $listaPlatillos = $jsonPlatillos['data']['platillos'] ?? [];
    $platillos = collect($listaPlatillos);

    $detalles = $pedido['detalles'] ?? [];
    foreach ($detalles as $key => $detalle) {
        $infoPlatillo = $platillos->where('id', $detalle['platillo_id'])->first();
        $detalles[$key]['nombre_platillo'] = $infoPlatillo['nombre'] ?? 'Platillo #' . $detalle['platillo_id'];
    }
    
    $pedido['detalles'] = $detalles;

    return view('pedidos.show', compact('pedido'));
}

public function destroy($id)
{
    $token = session('cliente_token');

    // Enviamos la petición DELETE a la API
    $response = Http::withToken($token)->delete("http://127.0.0.1:8000/api/pedidos/{$id}");

    if ($response->successful()) {
        return redirect()->route('pedidos.index')->with('success', 'Pedido cancelado correctamente.');
    }

    return back()->with('error', 'No se pudo cancelar el pedido.');
}
}