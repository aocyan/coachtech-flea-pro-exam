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
<div class="evaluation__container">
        <input class="category__check" type="checkbox" id="evaluation_1" value="1" />
        <label class="category__button" for="evaluation_1" data-index="0"></label>
        <input class="category__check" type="checkbox" id="evaluation_2" value="2" />
        <label class="category__button" for="evaluation_2" data-index="1"></label>
        <input class="category__check" type="checkbox" id="evaluation_3" value="3" />
        <label class="category__button" for="evaluation_3" data-index="2"></label>
        <input class="category__check" type="checkbox" id="evaluation_4" value="4" />
        <label class="category__button" for="evaluation_4" data-index="3"></label>
        <input class="category__check" type="checkbox" id="evaluation_5" value="5" />
        <label class="category__button" for="evaluation_5" data-index="4"></label>
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
                <span class="selling-products">{{ $seller_count }}</span>
            @else
                <span class="selling-products">{{ $transaction_count }}</span>
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
            @if(($new_count !== $before_count) || (!empty($product -> transaction_user_id)))
            <div class="product-item">
                <a class="product-item__link" href="{{ route('transaction.index', $product->id) }}">
                        @if( empty($user -> id !== $product_user -> id) )
                        <span class="selling-products__count">{{ $seller_comment_individual }}</span>
                        @elseif( empty($user -> id === $product_user -> id) )
                        <span class="selling-products__count">{{ $transaction_comment_individual }}</span>
                        @endif
                    <img class="product__image" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
                    <div class="product__text">
                        <input class="name--text" type="text" name="name" value="{{ $product['name'] }}" readonly />
                    </div>
                </a>
            </div>
            @endif
        @endforeach
    @endif
</div>

<script>
    const rating = @json($user_evaluation);
    const labels = document.querySelectorAll('.category__button');

    labels.forEach((label, index) => {
        if (index < Math.round(rating)) {
            label.classList.add('active');
        } else {
            label.classList.remove('active');
        }
    });
</script>

@endsection