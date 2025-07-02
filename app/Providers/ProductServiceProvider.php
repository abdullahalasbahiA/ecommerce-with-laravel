<?php

// app/Services/ProductService.php
namespace App\Providers;

use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


class ProductServiceProvider implements ProductServiceInterface
{
    public function getAllProducts()
    {
        return Product::with('features')->get();
    }

    public function getProductById($id)
    {
        return Product::with('features')->findOrFail($id);
    }

    public function createProduct(array $data, ?UploadedFile $image, ?array $features)
    {
        // Handle image upload
        $imagePath = $image ? $image->store('products', 'public') : null;

        // Create product
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
            'image_url' => $imagePath,
            'brand_id' => $data['brand_id'],
        ]);

        // Attach features if they exist
        if ($features) {
            $product->features()->sync($features);
        }

        return $product;
    }

    public function updateProduct($id, array $data, ?UploadedFile $image, ?array $features)
    {
        $product = Product::findOrFail($id);

        $updateData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ];

        // Handle image update
        if ($image) {
            // Delete old image if exists
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $updateData['image_url'] = $image->store('products', 'public');
        }

        $product->update($updateData);

        // Sync features
        if ($features !== null) {
            $product->features()->sync($features);
        }

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete the image from storage
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();
    }

    public function searchProducts(array $filters)
    {
        $query = Product::latest()->with(['features']);

        if (!empty($filters['features'])) {
            $query->whereHas('features', function ($q) use ($filters) {
                $q->whereIn('features.id', $filters['features']);
            }, '>=', count($filters['features']));
        }

        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        return $query->paginate(10);
    }
}