<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


    public function jsonIndex()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'empty' => true,
                'message' => 'Your cart is empty'
            ]);
        }

        return response()->json($cart);
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Calculate total
        $total = 0;
        foreach ($products as $id => $product) {
            $total += $product->price * $product->quantity;
        }

        return view('cart.index');
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id'
            ]);

            // Get the product
            $product = Product::find($request->product_id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Get current cart
            $cart = session()->get('cart', []);

            // Update cart
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image_url" => $product->image_url, // Changed to match your frontend
                    "product_id" => $product->id // Added for reference
                ];
            }

            // Save to session
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'message' => 'Product added to cart successfully!',
                'cart' => $cart // Optional - you might want to omit this for security
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding to cart: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $product_id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'cart' => $cart,
                'message' => 'Cart updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    public function destroy($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'message' => 'Product removed successfully'
        ]);
    }
}
