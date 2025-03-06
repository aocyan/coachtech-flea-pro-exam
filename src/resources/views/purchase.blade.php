@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<nav>
    <div class="header-nav">
        <div class="nav__search">
            <input class="nav__search--text" type="text" name="search" placeholder="なにをお探しですか？" />
        </div>
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
</nav>
<form class="comment-form" action="{{ url()->current() }}" method="get">
    @csrf
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
                    <input class="price--text" type="text" value="￥{{ number_format($product->price) }}" />
                </div>
            </div>
        </div>
        <div class="product__pay">
            <div class="pay__name">
                <p>支払い方法</p>
            </div>
            <select class="pay__select" name="pay" onchange="this.form.submit()" >
			    <option class="select--option" disabled selected>選択してください</option>
			    <option class="select--option" value="コンビニ払い" {{ old('pay', session('pay_method')) == 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
			    <option class="select--option" value="カード支払い" {{ old('pay', session('pay_method')) == 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
            </select>
        </div>
        <div class="product__deliver">
            <div class="deliver__container">
                <div class="deliver__name">
                    <p>配送先</p>
                </div>
                <div class="deliver__link">
                    <a class="address-link" href="/purchase/address">変更する</a>
                </div>
            </div>
            <div class="deliver__address">
                <div class="deliver__postal">
                    <input class="postal__number" type="text" value="〒111-2222" />
                </div>
                <div class="user__address">
                    <input class="user__address--text" type="text" value="住所" />
                    <input class="user__building--text" type="text" value="建物" />
                </div>
            </div>
        </div>
    </div>
    <div class="product__box-right">
        <table class="product__summary">
            <tbody>
                <tr>
                    <th>商品代金</th>
                    <td><input class="summary__price--text" type="text" value="￥{{ number_format($product->price) }}"  readonly/></td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td><input class="summary__pay--text" type="text" value="{{ old('pay',session('pay_method')) }}" readonly /></td>
                </tr>
            </tbody>
        </table>
        <div class="purchase__link">
            <a class="purchase__link--button" href="/">購入する</a>
        </div>
    </div>
</form>

@endsection