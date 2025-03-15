<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function store(Request $request)
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

        session(['user_name' => $user->name]);

        return view('edit', compact('user','profile'));
    }

    public function edit()
    {
        $user_name = session('user_name', '');

        return view('edit', compact('user_name'));
    }

    public function update(Request $request)
    {
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
        $profile->postal = $request->input('postal');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');
        $profile->save();

        Auth::login($user);

        $products = Product::all();

        return view('index',compact('products'));
    }

    public function index()
    {
        $products = Product::all();

        return view('index',compact('products'));
    }

    public function login()
	{
		return view('auth.login');
	}

    public function register()
	{
		return view('auth.register');
	}

    public function mypage()
    {
        return view('mypage');
    }
}
