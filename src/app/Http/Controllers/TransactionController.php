<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request,$item_id) 
    {
        $user = Auth::user();
        $user_profile = Profile::find($user -> id);

        $product = Product::find($item_id);
        $product_user = User::find($product -> product_user_id);
        $product_user_profile = Profile::find($product_user -> id);
     
        return view('transaction', compact(
            'user',
            'user_profile',
            'product', 
            'product_user',
            'product_user_profile'
        ));
    }
}
