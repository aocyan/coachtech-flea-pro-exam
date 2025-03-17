<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
	{
        $tab = $request->query('tab', 'default');
        $user = Auth::user();

        $products = Product::select('id', 'name', 'image','sold_at')->get();

        if ($tab === 'mylist') {
            if($user) {
                $products = Product::whereHas('likes', function ($query) use ($user) {$query->where('user_id', $user->id);})->get();
            }
            else {
                $products = collect();
            }
        }

		return view('index', compact('products','tab'));
	}

    public function show($item_id)
    {
        $product = Product::where('id', $item_id)->first();

        $product->load('categories');

        $selectedCategories = $product->categories->pluck('name')->toArray();

        $comments = Comment::with('user')->where('product_comment_id', $item_id)->get();

        $likeCount = Like::where('product_id', $product->id)->count();
        $commentCount = $comments->count();
        $liked = Auth::check() ? Like::where('user_id', Auth::id())->where('product_id', $product->id)->exists() : false;

        return view('exhibition', compact('product','selectedCategories','comments','commentCount','likeCount','liked'));
    }

    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::findOrFail($product_id);
        $user = Auth::user();
        
        if ($request->has('like')) {
            $likeValue = (int) $request->input('like');

            if ($likeValue === 1) {
                Like::updateOrinsert(
                    ['user_id' => $user->id, 'product_id' => $product_id],
                    ['likes' => 1]
                );
            } 
            else {
                Like::where('user_id', $user->id)->where('product_id', $product_id)->delete();
            }
        }

        if ($request->has('comment') && !empty($request->comment)) {
            Comment::create([
                'product_comment_id' => $request->product_id,
                'user_comment_id' => Auth::id(),
                'comment' => $request->comment,
            ]);
        }

        $comments = Comment::with('user.profile')->where('product_comment_id', $product_id)->get();

        $commentCount = $comments->count();
        $likeCount = Like::where('product_id', $product_id)->where('likes', true)->count();

        $liked = Auth::check() ? Like::where('user_id', $user->id)->where('product_id', $product_id)->exists() : false;

        $selectedCategories = $product->categories->pluck('name')->toArray();

        return redirect()->route('product.show', $product_id)->with(compact('product', 'selectedCategories', 'comments', 'commentCount', 'likeCount','liked'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', '%' . $query . '%')->get();

        return view('product.search', compact('products'));
    }
}
