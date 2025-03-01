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
        <div class="nav__container">
            <div class="nav__logout">
                <a class="logout-link" href="/login">ログアウト</a>
            </div>
            <div class="nav__maypage">
                <a class="mypage-link" href="/mypage">マイページ</a>
            </div>
            <div class="nav__sell">
                <a class="sell-link" href="/sell">出品</a>
            </div>
        </div>
    </div>
    <div class="main-nav">
        <div class="nav__suggest">
                <a class="suggest-link" href="">おすすめ</a>
        </div>
        <div class="nav__mylist">
                <a class="mylist-link" href="/">マイリスト</a>
        </div>
    </div>
</nav>
<div class="product__container">
@foreach ($products as $product)
    <div class="product-item">
        <a class="product-item__link" href="{{ route('product.show', $product->id) }}">
            <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
            <div class="product__text">
                <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
            </div>
        </a>
    </div>
@endforeach
</div>

@endsection