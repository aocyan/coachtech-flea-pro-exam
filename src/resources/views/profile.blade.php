@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
<div class="profile__container">
    <img class="user__image" src="{{ asset('storage/users/' . basename($profile->image)) }}" alt="画像が選択されていません" />
    <input class="user__name" type="text" value="{{ $user->name }}" readonly />
    <a class="user__profile" href="{{ route('user.edit') }}">プロフィールを編集</a>
</div>
<div class="main-nav">
    <div class="nav__recommend">
        <a class="recommend-link {{ request('tab') === 'sell' ? 'active' : '' }}" 
            href="{{ route('mypage.check', ['tab' => 'sell']) }}">出品した商品</a>
    </div>
    <div class="nav__mylist">
        <a class="mylist-link {{ request('tab') === 'buy' ? 'active' : '' }}" 
            href="{{ route('mypage.check', ['tab' => 'buy']) }}">購入した商品</a>
    </div>
    <div class="nav__transaction">
        <a class="transaction-link {{ request('tab') === 'transaction' ? 'active' : '' }}" 
            href="{{ route('mypage.check', ['tab' => 'transaction']) }}">取引中の商品
            @if(empty($user -> id !== $product_user -> id))
                <span class="selling-products">{{ $transaction_count }}</span>
            @else
                <span class="selling-products">{{ $seller_count }}</span>
            @endif
        </a>
    </div>
</div>
<div class="product__container">
    @if ($tab === 'sell' || $tab === 'buy')
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
    @elseif ($tab === 'transaction')
        @foreach ($products as $product)
            <div class="product-item">
                <a class="product-item__link" href="{{ route('transaction.index', $product->id) }}">
                        @if( empty($user -> id !== $product_user -> id) )
                        <span class="selling-products__count">{{ $transaction_count }}</span>
                        @elseif( empty($user -> id === $product_user -> id) )
                        <span class="selling-products__count">{{ $seller_count }}</span>
                        @endif
                    <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
                    <div class="product__text">
                        <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>


@endsection