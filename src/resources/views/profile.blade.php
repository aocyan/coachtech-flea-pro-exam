@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
        <div class="user__container">
            <div class="user__image">
                <img class="user__image--item" src="" alt="" />イメージ
            </div>
            <div class="user__logo">
                <p>ユーザー名</p>
            </div>
            <div class="profile-edit">
                <a class="profile-edit--button" href="/mypage/profile">プロフィール編集</a>
            </div>
        </div>
        <div class="user-product__container">
            <div class="sell__link">
                <a class="sell__link--button" href="">出品した商品</a>
            </div>
            <div class="purchase__link">
                <a class="purchase__link--button" href="/">購入した商品</a>
            </div>
        </div>
    </div>
</nav>

<form class="product-form" action="" method="post">
    @csrf
    <div class="product__container">
        {{--@foreach ($products as $product)--}}
        <div class="product-item">
            <a class="product-item__link" href="">
            <img class="product__image" src="" alt="" />画像
                <div class="product__text">
                    <input class="name--text" type="text" name="name" value="商品名" />
                </div>
            </a>
        </div>
        {{--@endforeach--}}
    </div>
</form>

@endsection