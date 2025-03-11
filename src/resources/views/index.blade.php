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
        @if (Auth::check())
        <form class="form-log" action="/logout" method="post">
        @csrf
            <button class="logout-link">ログアウト</button>         
        </form>
        <a class="mypage-link" href="/mypage">マイページ</a>
        <a class="sell-link" href="/sell">出品</a>
        @endif
    </div>
</nav>
<div class="main-nav">
    @if (Auth::check())
    <div class="nav__recommend">
        <a class="recommend-link" href=""> おすすめ </a>
    </div>
    <div class="nav__mylist">
        <a class="mylist-link" href="/mypage">マイリスト</a>
    </div>
    @endif
</div>
<div class="product__container">
@foreach ($products as $product)
    @if (!auth()->check() || (auth()->check() && $product->product_user_id !== auth()->user()->id))
        <div class="product-item">
            <a class="product-item__link" href="{{ route('product.show', $product->id) }}">
                <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
                <div class="product__text">
                    <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
                </div>
            </a>
        </div>
    @endif
@endforeach
</div>

@endsection