@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
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
</nav>
<div class="product__detail">
    <div class="product__name">
        <input class="product__name--text" type="text" value="{{ $product->name }}" readonly />
    </div>
    <div class="product__brand">
        <input class="product__brand--text" type="text" value="{{ $product->brand }}" readonly />
    </div>
    <div class="product__price">
        <span class="price--mark">￥</span><input class="product__price--text" type="text" value="{{ $product->price }}（税込）" readonly />
    <div class="product__mark">
        <input class="mark__check" type="checkbox" name="mark" id="star" />
        <label class="mark__button" for="star">☆</span></label>
        <input class="mark__check" type="checkbox" name="mark" id="comment" />
        <label class="mark__button" for="comment">💬</label>
    </div>
    <div class="purchase__link">
        <a class="purchase__link--button" href="/purchase">購入手続きへ</a>
    </div>
    <div class="product__explain">
        <div class="explain__header">
            <p>商品説明</p>
        </div>
        <div class="explain__color">
            カラー
            <input class="explain__color--text" type="text" value="{{ $product->color }}"  readonly />
        </div>
        <div class="explain__detail">
            <input class="explain__detail--text" value="{{ $product->description }}" />
        </div>
    </div>
    <div class="product__info">
        <div class="info__header">
            <p>商品の情報</p>
        </div>
        <div class="category__list">
            <span class="category__list--item">カテゴリー</span>
            @php
                $selectedCategories = $product->categories->pluck('name')->toArray();
            @endphp
            @foreach ($product->categories as $category)
                <input class="category__check" type="checkbox" name="category[]" id="category_{{ $category->id }}" value="{{ $category->id }}" />
                <label class="category__button" for="category_{{ $category->id }}">{{ $category->name }}</label>
            @endforeach
        </div>
        <div class="product__condition">
            <span class="product__condition--item">商品の状態</span>
            <input class="condition--text" type="text" value="{{ $product->condition }}" readonly />
        </div>
    </div>
    <div class="product__comment">
        <input class="comment__figure" type="text" value="コメント(1)" readonly />
        <div class="user__info">
            <div class="user__info-detai">
                <img class="user__image--item" src="" alt="" />イメージ
                <input class="user__name" type="text" value="admin" readonly />
            <div>
            <div class="user__comment">
                <input class="user__comment--text" type="text" value="こちらにコメントが入ります" readonly />
            </div>
        </div>
    </div>
    <form class="comment-form" action=" method="">
    @csrf
        <div class="form__group">
            <div class="comment__logo">
                <p>商品へのコメント</p>
            </div>
            <textarea class="form__textarea--text" name="comment"></textarea>
            <div class="form__button">
                <button class="form__button-submit" type="submit" name="comment_submit">コメントを送信する</button>
            </div>
        </div>
    </form>
</div>

@endsection