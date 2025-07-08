<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
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
        $product_user = User::find($product -> product_user_id);
        $product_user_id = $product -> product_user_id;
        $product_user_profile = Profile::find($product_user -> id);
       
        $before_count = $user_profile -> before_evaluation_count;
        $new_count = $user_profile -> evaluation_count;

        if($user_id === $product_user_id && $before_count < $new_count)
        {
            $before_count++ ;
            $user_profile -> before_evaluation_count = $before_count;
            $user_profile -> save();
        }

        if($user -> id !== $product -> product_user_id){
            $product -> transaction_user_id = $user -> id;
            $product -> seller_user_id = null;
            $product -> save();
        }
        
        $product_items = Product::where('transaction_user_id', $user_id)
                            -> orWhere(function ($query) {
                                $query -> whereColumn('product_user_id', '!=', 'transaction_user_id');
                            })
                            -> with(['transactions' => function($query) {
                                $query->orderBy('created_at', 'desc');
                            }])
                            -> orderByRaw('
                                (SELECT MAX(created_at) FROM transactions WHERE transactions.product_transaction_id = products.id) DESC
                            ')
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

        $search_comment = Transaction::where('product_transaction_id', $product -> id)
                            -> orderBy('created_at', 'desc')
                            -> first();

        if($search_comment){
            if($user_id !== $product_user_id)
            {
                $search_comment -> seller_comment_count = 0;
                $search_comment -> save();
            } elseif ($user_id === $product_user_id){
                $search_comment -> transaction_comment_count = 0;
                $search_comment -> save();
            }
        }
 
        return view('transaction', compact(
            'item_id',
            'user',
            'user_profile',
            'product', 
            'product_items',
            'product_user',
            'product_user_profile',
            'transaction_user',
            'transaction_user_profile',
            'user_comments',
            'other_comments',
            'new_count',
            'before_count',
        ));
    }

    public function store(TransactionRequest $request, $item_id)
    {
        $user = Auth::User();
        $user_id = $user -> id;

        $product = Product::find($item_id);

        $path = null;
        if ($request->hasFile('image')) {
            $file = $request -> file('image');
            $fileName = $file -> getClientOriginalName();
            $path = $file -> storeAs('transactions', $fileName, 'public');
        }

        $seller_comment_count = 0;
        $transaction_comment_count = 0;

        $comment = Transaction::create([
            'user_transaction_id' => $user_id,
            'product_transaction_id' => $item_id,
            'comment' => $request->comment,
            'seller_comment_count' => $seller_comment_count,
            'transaction_comment_count' => $transaction_comment_count,
            'image' => $path,
        ]);

        if ($user->id === $product -> product_user_id) 
        {
            $seller_comment = Transaction::where('product_transaction_id', $item_id)
                                 -> where('user_transaction_id', $product -> product_user_id)
                                 -> whereNotNull('comment')
                                 -> first();

            if ($seller_comment) 
            {
                $seller_comment -> seller_comment_count = (int) $seller_comment -> seller_comment_count + 1;
                $seller_comment -> save();
            }
            $seller_comment_count = $seller_comment ? $seller_comment -> seller_comment_count : 0;
        } elseif ($user -> id !== $product -> product_user_id) {
                $transaction_comment = Transaction::where('product_transaction_id', $item_id)
                                        -> where('user_transaction_id', '!=', $product -> product_user_id)
                                        -> whereNotNull('comment')
                                        -> first();

            if ($transaction_comment) 
            {
                $transaction_comment -> transaction_comment_count = (int) $transaction_comment -> transaction_comment_count + 1;
                $transaction_comment -> save();
            }
            $transaction_comment_count = $transaction_comment ? $transaction_comment -> transaction_comment_count : 0;
        }

        $comment -> seller_comment_count = $seller_comment_count;
        $comment -> transaction_comment_count = $transaction_comment_count;
        $comment -> save();

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
                $comment -> save();

                $search_comment = Transaction::where('product_transaction_id', $product -> id)
                                    -> orderBy('created_at', 'desc')
                                    -> first();

                if ($user->id === $product->product_user_id) {
                    $search_comment -> seller_comment_count = max(0, (int)$search_comment -> seller_comment_count - 1);
                    $search_comment -> save();
                } elseif ($user->id !== $product->product_user_id) {
                    $search_comment -> transaction_comment_count = max(0, (int)$search_comment -> transaction_comment_count - 1);
                    $search_comment -> save();
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

    public function evaluation(Request $request, $item_id)
    {
        $user = Auth::User();

        $product = Product::find($item_id);
        $product_user_id = $product -> product_user_id;
    
        $product_user_profile = Profile::find($product_user_id);

        $evaluation = $request -> input('evaluation');

        $now_evaluation_score = $product_user_profile -> evaluation;
        $count = $product_user_profile -> evaluation_count;

        $new_average = round((($now_evaluation_score * $count) + $evaluation) / ($count + 1), 1);

        $product_user_profile -> evaluation_count = $count+1;
        $product_user_profile -> evaluation = $new_average;

        $product_user_profile -> save();

        $product -> update([
            'seller_user_id' => $user -> id,
            'purchaser_user_id' => $user -> id,
            'sold_at' => now(),
        ]);

        $product -> save(); 

        return redirect() -> route('product.index');       
    }

    public function seller(Request $request, $item_id)
    {
        $user = Auth::User();
        $product = Product::find($item_id);
        $transaction_user_id = $product -> transaction_user_id;
    
        $transaction_user_profile = Profile::find($transaction_user_id);

        $evaluation = $request -> input('evaluation');

        $now_evaluation_score = $transaction_user_profile -> evaluation;
        $now_count = $transaction_user_profile -> evaluation_count;
        $now_count++;

        $before_count = $transaction_user_profile -> before_evaluation_count;
        $before_count++;

        $now_evaluation_score += $evaluation;
        $new_evaluation_average = round($now_evaluation_score / $now_count, 1);

        $transaction_user_profile -> evaluation_count = $now_count;
        $transaction_user_profile -> before_evaluation_count = $before_count;
        $transaction_user_profile -> evaluation = $new_evaluation_average;

        $transaction_user_profile -> save();

        $product -> update([
            'transaction_user_id' => null,
            'seller_user_id' => null,
        ]);

        return redirect() -> route('product.index');       
    }
}


