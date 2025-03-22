<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register()
	{
		return view('auth.register');
	}

    public function store(RegisterRequest $request)
    {
        $user = User::create([            
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
        ]);
        $userId = $user->id;

        $profile = Profile::create([
            'profile_user_id' => $userId,
            'image' => '',
            'postal' => '',
            'address' => '',
            'building' => '',
        ]);

        session(['user_id' => $userId, 'user_name' => $user->name, 'profile' => $profile]);

        return redirect()->route('user.edit');
    }

    public function edit()
    {
        if (session('user_id') && !Auth::check()) {
            $userId = session('user_id');
            $user = User::findOrFail($userId);
            $profile = session('profile');
        }
        else {
            $user = Auth()->user();
            $profile = $user->profile; 
        }
        return view('edit', compact('user','profile'));
    }

    public function update(ProfileRequest $request)
    {
        $validatedData = $request->validated();

            $user = User::orderBy('created_at', 'desc')->orderBy('id', 'desc')->first();

            $user->name = $request->input('name');
            $user->save();

            $profile = $user->profile;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $path = $file->storeAs('users', $fileName, 'public');
                $profile->image = $path;
            }
            if ($request->has('postal')) {
                $profile->postal = $request->input('postal');
            }
            if ($request->has('address')) {
                $profile->address = $request->input('address');
            }
            if ($request->has('building')) {
                $profile->building = $request->input('building');
            }
            $profile->save();

            Auth::login($user);

            $products = Product::all();

            
            return view('index',compact('products'));
    }

    public function login()
	{
        return view('auth.login');
	}

    public function loginCertification(LoginRequest $request)
    {
        $validatedData = $request->validated();

        if (Auth::attempt([
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ])) {
            return redirect()->route('product.index');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています',
        ]);
    }

    public function mypage(Request $request)
    {
        $tab = $request->query('tab', 'default');

        $user = Auth()->user();

        $products = Product::select('id', 'name', 'image','sold_at')->get();
        $profile = $user->profile;

        if ($tab === 'sell') {
            $products = Product::where('product_user_id', $user->id)->get();
        }
        elseif ($tab === 'buy') {
            $products = Product::where('purchaser_user_id', $user->id)->get();
        }
        else {
            $products = collect(); 
        }

		return view('profile', compact('products','user','profile','tab'));
    }
}
