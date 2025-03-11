<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth()->user();
        $userId = $user->id;

        $product = Product::create([
            'product_user_id' => $userId,
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'image' => $path,
            'condition' => $request->condition,
            'description' => $request->description,    
        ]);

        $categoryIds = [];
        foreach ($request->input('category') as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $categoryIds[] = $category->id;
        }

        $product->categories()->attach($categoryIds, ['created_at' => now(), 'updated_at' => now()]);

        $products = Product::all();

        return view('index',compact('products'));
    }

    public function index(Request $request,$item_id)
    {
        $payMethod = $request->input('pay', '選択してください');

        $product = Product::find($item_id);

        session(['pay_method' => $payMethod]);      

        $profile = Auth()->user()->profile;

        $postalCode = $profile->postal;
        $postalCodeFirst = substr($postalCode, 0, 3);
        $postalCodeLast = substr($postalCode, 3, 4);

        return view('purchase', compact('payMethod', 'item_id', 'product', 'profile','postalCodeFirst','postalCodeLast'));
    }
}
