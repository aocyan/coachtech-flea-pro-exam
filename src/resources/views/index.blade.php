@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<nav>
    <div class="header-nav">
        <div class="nav__search">
            <input class="nav__search--text" type="text" name="search" placeholder="なにをお探しですか？" />
        </div>
        <form class="form-log" action="/logout" method="post">
        @csrf
        @if (Auth::check())
            <button class="logout-link">ログアウト</button>  
        </form>
        <a class="mypage-link" href="{{ route('mypage.check') }}">マイページ</a>
        <a class="sell-link" href="{{ route('sell.create') }}">出品</a>
        @endif
    </div>
    @guest
            <a class="no__login-link" href="{{ route('login') }}">ログイン</a>
            <a class="no__login-mypage-link" href="{{ route('login') }}">マイページ</a>
            <a class="no__login-sell-link" href="{{ route('login') }}">出品</a>
    @endguest
</nav>
<div class="main-nav">
    <div class="nav__recommend">
        <a class="recommend-link" href="{{ route('product.index') }}"> おすすめ </a>
    </div>
    <div class="nav__mylist">
        <a class="mylist-link" href="{{ route('product.index', ['tab' => 'mylist']) }}">マイリスト</a>
    </div>
</div>
<div class="product__container">
    @foreach ($products as $product)
        @if (!Auth()->check() || (Auth()->check() && $product->product_user_id !== Auth()->user()->id) && ($tab ?? '') !== 'mylist')
            <div class="product-item">
                <a class="product-item__link" href="{{ route('product.show', $product->id) }}">
                    <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
                    <div class="product__text">
                        <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
                    </div>
                    @if ($product->sold_at)
                        <div class="product__sold">
                            <p class="product__sold--text">sold</p>
                        </div>
                    @endif
                </a>
            </div>
        @endif
    @endforeach
    @if (($tab ?? '') === 'mylist')
        @foreach ($products as $product)
            <div class="product-item">
                <a class="product-item__link" href="{{ route('product.show', $product->id) }}">
                    <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
                    <div class="product__text">
                        <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
                    </div>
                    @if ($product->sold_at)
                        <div class="product__sold">
                            <p class="product__sold--text">sold</p>
                        </div>
                    @endif
                </a>
            </div>
        @endforeach
    @endif
</div>

@endsection