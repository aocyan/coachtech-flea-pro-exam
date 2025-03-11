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
<div class="image-detail__container">
    <div class="product__image">
        <img class="product__image--item" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
    </div>
    <div class="product__detail">
        <div class="product__name">
            <input class="product__name--text" type="text" value="{{ $product->name }}" readonly />
        </div>
        <div class="product__brand">
            <input class="product__brand--text" type="text" value="{{ $product->brand }}" readonly />
        </div>
        <div class="product__price">
            <span class="price--mark">￥</span><input class="product__price--text" type="text" value="{{ number_format($product->price) }}（税込）" readonly />
        </div>
        @if (Auth::check())
        <div class="product__mark">
            <input class="mark__check" type="checkbox" name="mark" id="star" />
            <label class="mark__button" for="star">☆</span></label>
            <input class="mark__check" type="checkbox" name="mark" id="comment" />
            <label class="mark__button" for="comment">💬</label>
        </div>
        @endif
        @if (Auth::check())
        <div class="purchase__link">
            <a class="purchase__link--button" href="{{ route('purchase.index', $product->id) }}">購入手続きへ</a>
        </div>
        @endif
        <div class="product__explain">
            <div class="explain__header">
                <p>商品説明</p>
            </div>
            <div class="explain__color">
                <input class="explain__color--text" type="text" value="カラー：{{ $product->color }}"  readonly />
            </div>
            <div class="explain__description">
                <textarea class="explain__description--text" readonly>{{ $product->description }}</textarea>
            </div>
        </div>
        <div class="product__info">
            <div class="info__header">
                <p>商品の情報</p>
            </div>
            <div class="category__list">
                <span class="category__list--item">カテゴリー</span>
                @foreach ($product->categories as $category)
                    <input class="category__check" type="checkbox" name="category[]" id="category_{{ $category->id }}" value="{{ $category->id }}" disabled />
                    <label class="category__button" for="category_{{ $category->id }}">{{ $category->name }}</label>
                @endforeach
            </div>
            <div class="product__condition">
                <span class="product__condition--item">商品の状態</span>
                <input class="condition--text" type="text" value="{{ $product->condition }}" readonly />
            </div>
        </div>
        <div class="product__comment">
            <input class="comment__figure" type="text" value="コメント({{$commentCount}})" readonly />
            @foreach ($comments as $comment)
            <div class="user__info">
                @if ($comment->user)
                <div class="user__info-detail">
                    <img class="user__image--item" src="{{ asset('storage/users/' . basename($comment->user->profile->image)) }}" alt="{{ $comment->user->image }}" />
                    <input class="user__name" type="text" value="{{ $comment->user->name }}" readonly />
                </div>
                <div class="user__comment">
                    <textarea class="user__comment--text" type="text" readonly>{{ $comment->comment }}</textarea>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @if (Auth::check())
        <form class="comment-form" action="{{ route('comments.store') }}" method="post">
        @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form__group">
                <div class="comment__logo">
                    <p>商品へのコメント</p>
                </div>
                <textarea class="form__textarea--text" name="comment"></textarea>
                <div class="form__button">
                    <button class="form__button-submit" type="submit" name="submit">コメントを送信する</button>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>

@endsection