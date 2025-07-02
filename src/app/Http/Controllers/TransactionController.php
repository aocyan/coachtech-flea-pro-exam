<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
        $user_id = $user -> id;

        $user_profile = Profile::find($user -> id);

        $product = Product::find($item_id);

        if($user -> id !== $product -> product_user_id){
            $product -> transaction_user_id = $user -> id;
            $product -> seller_user_id = null;
            $product -> save();
        }
        
        $product_user = User::find($product -> product_user_id);
        $product_user_profile = Profile::find($product_user -> id);

        $products = Product::where('transaction_user_id', $user_id)
                        -> orWhere('seller_user_id', $user_id)
                        -> get();

        $transaction_user_id = Product::where('transaction_user_id', $product->transaction_user_id)
                                    -> first()
                                    -> transaction_user_id;
    
        $transaction_user = User::find($transaction_user_id);
        $transaction_user_profile = Profile::find($transaction_user_id);

        $user_comments = Transaction::where('user_transaction_id', $user -> id)
                        -> where('product_transaction_id', $product -> id)
                        -> get();

        $other_comments = Transaction::where('user_transaction_id', '!=', $user -> id)
                        -> where('product_transaction_id', $product -> id)
                        -> with(['user.profile'])
                        -> get();
            
        if($user -> id === $product_user -> id)
        {
            $product->update([
                'seller_user_id' => $user->id,
            ]);
        }
 
        return view('transaction', compact(
            'item_id',
            'user',
            'user_profile',
            'product', 
            'products',
            'product_user',
            'product_user_profile',
            'transaction_user',
            'transaction_user_profile',
            'user_comments',
            'other_comments',
        ));
    }

    public function store(Request $request, $item_id)
    {
        $user = Auth::User();
        $user_id = $user -> id;

        $product = Product::find($item_id);

        $path = null;
        if($request -> hasFile('image')) 
        {
            $file = $request -> file('image');
            $fileName = $file -> getClientOriginalName();
            $path = $file -> storeAs('transactions', $fileName, 'public');
        }

        $comment = Transaction::create([     
            'user_transaction_id' => $user_id,
            'product_transaction_id' => $item_id,       
            'comment' => $request->comment,
            'image' => $path,
        ]);
        
        // 該当するproduct_transaction_idを持つすべてのコメントをカウント
        $seller_comment_count = Transaction::where('product_transaction_id', $item_id)
            ->where('user_transaction_id', $product->product_user_id)
            ->count();
        
        $transaction_comment_count = Transaction::where('product_transaction_id', $item_id)
            ->where('user_transaction_id', '!=', $product->product_user_id)
            ->count();
        
        // 今作ったコメントにそれぞれのcountをセット
        $comment->seller_comment_count = $seller_comment_count;
        $comment->transaction_comment_count = $transaction_comment_count;
        $comment->save();

        return redirect() -> route('transaction.index', ['item_id' => $item_id]);
    }

    public function edit(Request $request, $item_id)
    {
        $user = Auth::User();
        $product = Product::find($item_id);

        $comments = $request -> input('comment');

        if($request -> has('revise_comment')) 
        {
            foreach($comments as $id => $comment_text)
            {
                $comment = Transaction::find($id);

                if($comment)
                {
                    $comment -> update(['comment' => $comment_text]);
                }
            }
        } elseif($request -> has('del_comment')) {

            $comment_id = $request -> input('del_comment');

            $comment = Transaction::find($comment_id);

            if($comment)
            {
                $comment -> comment = null;

                if($user -> id === $product -> product_user_id){
                    $comment -> seller_comment_count =  ((int)$comment -> seller_comment_count) -1;
                    $comment -> save();
                } else {
                    $comment -> transaction_comment_count =  ((int)$comment -> transaction_comment_count) -1;
                    $comment -> save();
                }
            }
        } elseif($request -> has('del_img')) {

            $img_id = $request -> input('del_img');

            $img = Transaction::find($img_id);

            if($img) {
                $img -> image = null;
                $img -> save();
            }
        }

        return redirect() -> route('transaction.index', ['item_id' => $item_id]); 
    }
}
