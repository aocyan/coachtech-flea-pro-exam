@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<div class="main__container">
    <div class="product__box-left">   
        <div class="product__container">
            <div class="product__image">
                <img class="product__image--item" src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}" />
            </div>
            <div class="product__name-price">
                <div class="product__name">
                    <p>{{ $product->name }}</p>
                </div>
                <div class="product__price">
                    <input class="price--text" type="text" name="price" value="￥{{ number_format($product->price) }}" readonly />
                </div>
            </div>
        </div>
        <div class="product__pay">
            <div class="pay__name">
                <p>支払い方法</p>
            </div>
            <form class="comment-form" action="{{ url()->current() }}" method="get">
                <select class="pay__select" name="pay" onchange="this.form.submit()" >
			        <option class="select--option" value="" selected disabled>選択してください</option>
			        <option class="select--option" value="コンビニ払い" {{ old('pay', session('pay_method')) == 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
			        <option class="select--option" value="カード支払い" {{ old('pay', session('pay_method')) == 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
                </select>
                <div class="form__error">
                    @error('pay')
                        {{ $message }}
                    @enderror
                </div>
            </form>
        </div>
        <form class="comment-form" action="{{ route('purchase.store', ['product' => $product->id]) }}" method="post">
        @csrf
            <div class="product__deliver">
                <div class="deliver__container">
                    <div class="deliver__name">
                        <p>配送先</p>
                    </div>
                    <div class="deliver__link">
                        <a class="address-link" href="{{ route('purchase.address', ['item_id' => $product->id]) }}">変更する</a>
                    </div>
                </div>
                <div class="deliver__address">
                    <div class="deliver__postal">
                        <input class="postal__number" type="text" name="postal" value="〒{{ $postalCodeFirst }}-{{ $postalCodeLast }}" readonly />
                    </div>
                </div>
                <div class="user__address">
                    <input class="user__address--text" type="text" name="address" value="{{ session('new_address', $profile->address) }}" readonly />
                    <input class="user__building--text" type="text" name="building" value="{{ session('new_building',$profile->building) }}" readonly />
                </div>
            </div>
        </form>
    </div>
    <div class="product__box-right">
        <form class="comment-form" action="{{ route('purchase.store', ['product' => $product->id]) }}" method="post">
        @csrf
            <table class="product__summary">
                <tbody>
                    <tr>
                        <th>商品代金</th>
                        <td><input class="summary__price--text" type="text" name=price value="￥{{ number_format($product->price) }}"  readonly/></td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td><input class="summary__pay--text" type="text" name=pay value="{{ old('pay',session('pay_method')) }}" readonly /></td>
                    </tr>
                </tbody>
            </table>
            <div class="purchase__link">
                <button class="purchase__submit--button" type="submit" name="submit">購入する</button>
            </div>
        </form>
    </div>
</div>

@endsection