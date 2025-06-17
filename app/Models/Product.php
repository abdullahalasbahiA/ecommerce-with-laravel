<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name', 'description', 'price', 'stock_quantity', 'image_url'
    // ];

    protected $guarded = [];

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function types()
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term)
                  ->orWhere('description', 'like', $term);
        });
    }

    public function scopeWithBrand($query, $brands)
    {
        if (!$brands) return $query;
        
        return $query->whereHas('brands', function($q) use ($brands) {
            $q->whereIn('brands.id', $brands);
        });
    }

    public function scopeWithType($query, $types)
    {
        if (!$types) return $query;
        
        return $query->whereHas('types', function($q) use ($types) {
            $q->whereIn('product_types.id', $types);
        });
    }

    public function scopeWithFeature($query, $features)
    {
        if (!$features) return $query;
        
        return $query->whereHas('features', function($q) use ($features) {
            $q->whereIn('features.id', $features);
        });
    }

    public function scopeWithColor($query, $colors)
    {
        if (!$colors) return $query;
        
        return $query->whereHas('colors', function($q) use ($colors) {
            $q->whereIn('colors.id', $colors);
        });
    }

    public function scopePriceRange($query, $min, $max)
    {
        if (!$min && !$max) return $query;
        
        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        
        return $query;
    }

}
