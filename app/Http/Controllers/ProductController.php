<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        return view('products.index', [
            'products' => Product::all()
        ]);
    }

    public function show(Product $product)
    {
        return view('products.show');
    }

    public function create()
    {
        return view('products.create', [
            'brands' => Brand::all(),
            'types' => ProductType::all(),
            'features' => Feature::all(),
            'colors' => Color::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'brand_id' => 'required|exists:brands,id',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            return back()->with('error', 'Image upload failed');
        }

        // Create the product
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'image_url' => $imagePath,
        ]);

        // Redirect with success message
        return redirect()->route('products.index', $product->id)
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ];

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            // Store new image
            $updateData['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($updateData);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        // Delete the image from storage
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        // Delete the product from database
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('features')) {
            $query->whereHas('features', function ($q) use ($request) {
                $q->whereIn('features.id', $request->features);
            }, '>=', count($request->features));
        }

        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }



        // $products = $query->get();
        // return response()->json($products);
        $products = $query->paginate(10); // Use normal paginate()

        return response()->json([
            'data' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ]);
    }



}
