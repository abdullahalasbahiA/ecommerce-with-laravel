<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Calculate total
        $total = 0;
        foreach ($products as $id => $product) {
            $total += $product->price * $cart[$id];
        }

        return view('cart.index', compact('cart', 'products', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId] += $request->quantity ?? 1;
        } else {
            $cart[$productId] = $request->quantity ?? 1;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => array_sum($cart),
            'message' => 'Product added to cart'
        ]);
    }

    public function update(Request $request)
    {
        // Similar to add but replaces quantity
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId] = $request->quantity ?? 1;
        } else {
            $cart[$productId] = $request->quantity ?? 1;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => array_sum($cart),
            'message' => 'Product added to cart'
        ]);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        unset($cart[$request->product_id]);
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => array_sum($cart)
        ]);
    }
}
