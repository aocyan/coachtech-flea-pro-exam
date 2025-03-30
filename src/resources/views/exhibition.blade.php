@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
@endsection

@section('content')

<nav>
    @if (Auth::check())
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
    @endif
    @if (!Auth::check())
    <div class="header-nav">       
        <form class="form__search" action="{{ route('product.search') }}" method="get">
            <input class="nav__search--text" type="text" name="query" placeholder="なにをお探しですか？" />
            <button class="search--button" name="submit">検索</button>
        </form>
        <a class="login-link" href="{{ route('login') }}">ログイン</a>
        <a class="mypage-link" href="{{ route('login') }}">マイページ</a>
        <a class="sell-link" href="{{ route('login') }}">出品</a>
    </div>
    @endif
</nav>
<form action="{{ route('likeComment.store') }}" method="post">
@csrf
    <div class="image-detail__container">
        <div class="product__image">
            <img class="product__image--item" src="{{ asset('storage/products/' . urlencode(basename($product->image))) }}" alt="{{ $product->name }}" />
        </div>
        <div class="product__detail">
            <div class="product__name">
                <input class="product__name--text" type="text" value="{{ $product->name }}" readonly />
            </div>
            <div class="product__brand">
                <input class="product__brand--text" type="text" value="{{ $product->brand }}" readonly />
            </div>
            @if ($product->sold_at)
                <p class="product__sold--text">sold</p>
            @endif
            <div class="product__price">
                <span class="price--mark">￥</span><input class="product__price--text" type="text" value="{{ number_format($product->price) }}（税込）" readonly />
            </div>
            <table class="product__mark">
                <tr>
                    <th>
                        @if (Auth::check() && !$product->sold_at && $product->product_user_id !== Auth()->user()->id)                     
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="like" value="0">
                            <input class="mark__check" type="checkbox"  name="like" id="favorite" value="1" {{ $liked ? 'checked' : '' }} />
                            <label class="mark__button--like" for="favorite" >☆</label>
                        @else
                            <p class="no-mark__button--like">☆</p>
                        @endif
                    </th>
                    <th>
                        <input class="mark__check" type="checkbox" name="mark" id="comment" />
                        <label class="mark__button--comment" for="comment">💬</label>
                    </th>
                </tr>
                <tr>
                    <td><input class="mark__count" type="text" value="{{ $likeCount }}" readonly /></td>
                    <td><input class="mark__count" type="text" value="{{ $commentCount }}" readonly /></td>
                </tr>
            </table>
            @if (Auth::check() && !$product->sold_at && ($product->product_user_id !== Auth()->user()->id))
                <div class="purchase__link">
                    <a class="purchase__link--button" href="{{ route('purchase.index', ['item_id'=> $product->id]) }}">購入手続きへ</a>
                </div> 
            @elseif ($product->sold_at || (Auth::check() && $product->product_user_id === Auth()->user()->id))
                <div class="no-purchase__link">
                     <p class="no-purchase__link--button">購入手続きへ</p>
                </div>
            @elseif(!Auth::check())
                <div class="no-purchase__link">
                     <a class="purchase__link--button" href="{{ route('login') }}">購入手続きへ</a>
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
            <input type="hidden" name="product_id" value="{{ $product->id }}" />
            <div class="form__group">
                <div class="comment__logo">
                    <p>商品へのコメント</p>
                </div>
                <div class="form__error">
                    @error('comment')
                        {{ $message }}
                    @enderror
                </div>
                <textarea class="form__textarea--text" name="comment"></textarea>
                @if (Auth::check() && !$product->sold_at && ($product->product_user_id !== Auth()->user()->id))
                    <div class="form__button">
                        <button class="form__button-submit" type="submit" name="submit">コメントを送信する</button>
                    </div>
                @elseif ($product->sold_at || (Auth::check() && $product->product_user_id === Auth()->user()->id))
                    <div class="no-form__button">
                        <p class="no-form__button-submit">コメントを送信する</p>
                    </div>
                @elseif(!Auth::check())
                    <div class="no-form__button">
                        <a class="form__button-submit" href="{{ route('login') }}">コメントを送信する</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>

@endsection