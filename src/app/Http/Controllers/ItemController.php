<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
	{
        $products = Product::select('id', 'name', 'image')->get();

		return view('index', compact('products'));
	}

    public function show($item_id)
    {
        $product = Product::where('id', $item_id)->first();

        $product->load('categories');

        $selectedCategories = $product->categories->pluck('name')->toArray();

        return view('exhibition', compact('product','selectedCategories'));
    }

}
