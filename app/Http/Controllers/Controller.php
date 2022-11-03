<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 
    public function index()
    {
        return view("index", [
            "products" => Product::latest()->paginate(16),
            "brands" => Brand::all(),
            "categories" => Category::all(),
        ]);
    }

    // Filtering for search ,category and brand
    public function filter(Request $request)
    {
        if($request->ajax()){
            return view("products.product", [
                "products" => Product::latest()->filter(
                        request(['search', 'category', 'brand'])
                    )->paginate(16),
            ]);
        }
    }
}