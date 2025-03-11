<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $comments = Comment::with('user')->where('product_comment_id', $item_id)->get();

        $commentCount = $comments->count();

        return view('exhibition', compact('product','selectedCategories','comments','commentCount'));
    }

    public function store(Request $request)
    {
        Comment::create([
            'product_comment_id' => $request->product_id,
            'user_comment_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        $comments = Comment::with('user.profile')->where('product_comment_id', $request->product_id)->get();

        $commentCount = $comments->count();

        $product = Product::find($request->product_id);

        $selectedCategories = $product->categories->pluck('name')->toArray();

        return view('exhibition', compact('product','selectedCategories','comments','commentCount'));
    }

}
