<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('sell');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('products', $fileName, 'public');
        }

        Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'image' => $path,
            'condition' => $request->condition,
            'detail' => $request->detail,    
        ]);

        return redirect()->route('sell.create');
    }
}
