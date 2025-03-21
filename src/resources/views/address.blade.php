@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<nav>
    <div class="header-nav">
        <form class="form__search" action="{{ route('product.search') }}" method="get">
            <input class="nav__search--text" type="text" name="query" placeholder="なにをお探しですか？" />
            <button class="search--button" name="submit">検索</button>
        </form>
        <form class="form-log" action="/logout" method="post">
        @csrf
            <button class="logout-link">ログアウト</button>  
        </form>
        <a class="mypage-link" href="{{ route('mypage.check') }}">マイページ</a>
        <a class="sell-link" href="{{ route('sell.create') }}">出品</a>
    </div>
</nav>  
<div class="address-header">
    <div class="address-header__logo">
        <h2>住所の変更</h2>
    </div>
</div>
<form class="register-form" action="{{ route('address.update', ['item_id' => $product->id]) }}" method="post">
@csrf
@method('PATCH')
    <div class="form__group">
        <div class="form__group-title">
            <p>郵便番号</p>
        </div>
        <input class="form__input" type="text" name="postal" value="{{ old('postal',session('new_postal',$profile->postal)) }}"/>
        <div class="form__error">
            @error('postal')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>住所</p>
        </div>
        <input class="form__input" type="address" name="address" value="{{ old('address',session('new_address',$profile->address)) }}"/>
        <div class="form__error">
            @error('address')
                {{ $message }}
            @enderror
        </div>
        <div class="form__group-title">
            <p>建物名</p>
        </div>
        <input class="form__input" type="text" name="building" value="{{ old('building',session('new_building',$profile->building)) }}"/>
        <div class="form__error">
            @error('building')
                {{ $message }}
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="update">更新する</button>
        </div>
    </div>
</form>

@endsection