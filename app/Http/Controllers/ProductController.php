<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:electronics,clothing,home,other',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
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
            'category' => $validated['category'],
            'image_path' => $imagePath,
        ]);

        // Redirect with success message
        return redirect()->route('products.index', $product->id)
            ->with('success', 'Product created successfully');
    }

    public function destroy(Product $product)
    {
        // Delete the image from storage
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Delete the product from database
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
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
            'category' => 'required|string|in:electronics,clothing,home,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
        ];

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Store new image
            $updateData['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($updateData);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product updated successfully');
    }
}
