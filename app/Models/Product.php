<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where( fn($query) =>
                $query->where('name', 'like', '%' . $search . '%' ))
            );

        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->where( fn($query) =>
                $query->where('category_id', 'like', '%' . $category . '%' ))
            );

        $query->when($filters['brand'] ?? false, fn($query, $brand) =>
            $query->where( fn($query) =>
                $query->where('brand_id', 'like', '%' . $brand . '%' ))
            );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}