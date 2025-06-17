<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{

    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $brands = $request->input('brands', []);
        $types = $request->input('types', []);
        $features = $request->input('features', []);
        $colors = $request->input('colors', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'newest');

        $products = Product::query()
            ->when($searchTerm, fn($query) => $query->search($searchTerm))
            ->when($brands, fn($query) => $query->withBrand($brands))
            ->when($types, fn($query) => $query->withType($types))
            ->when($features, fn($query) => $query->withFeature($features))
            ->when($colors, fn($query) => $query->withColor($colors))
            ->when(
                $minPrice || $maxPrice,
                fn($query) => $query->priceRange($minPrice, $maxPrice)
            )
            ->when($sort === 'price_asc', fn($query) => $query->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn($query) => $query->orderBy('price', 'desc'))
            ->when($sort === 'newest', fn($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        $allBrands = Brand::all();
        $allTypes = ProductType::all();
        $allFeatures = Feature::all();
        $allColors = Color::all();

        return view('products.index', [
            'searchTerm' => $searchTerm,
            'products' => $request->input('products'),
            'allBrands' => $request->input('allBrands'),
            'allTypes' => $request->input('allTypes'),
            'allFeatures' => $request->input('allFeatures'),
            'allColors' => $request->input('allColors'),
            'searchTerm' => $request->input('searchTerm'),
            'brands' => $request->input('brands'),
            'types' => $request->input('types'),
            'features' => $request->input('features'),
            'colors' => $request->input('colors'),
            'minPrice' => $request->input('minPrice'),
            'maxPrice' => $request->input('maxPrice'),
            'sort' => $request->input('sort'),
        ]);

        return view('products.index', compact(
            'products','allBrands','allTypes','allFeatures','allColors',
            'searchTerm','brands','types','features','colors','minPrice','maxPrice',
            'sort'
        ));
    }

    public function searchApi(Request $request)
    {   
        $searchTerm = $request->input('q');

        $products = Product::query()
            ->when($searchTerm, fn($query) => $query->search($searchTerm))
            ->limit(5)
            ->get();

        return response()->json($products);
    }

}
