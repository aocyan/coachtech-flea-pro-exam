@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="left__box">
        <div class="other_transaction">
            <p class="other_transaction--text">その他の取引</p>
        </div>
    </div>
    <div class="right__box">
        <div class="transaction-header">
            <div class="transaction-header__img">
                <img class="header__img--item" src="{{ asset('storage/users/' . basename($product_user_profile -> image))  }}" alt="出品者画像" />
            </div>
            <div class="transaction-header__logo">
                <h2>「{{ $product_user -> name }}」さんとの取引画面</h2>
            </div>
            <div class="transaction-button">
                <button class="transaction-button--text">取引を完了する</button>
            </div>
        </div>
        <div class="product-detail">
            <div class="product-detail__img">
                <img class="product-detail__img--item" src="{{ asset('storage/products/' . basename($product -> image))  }}" alt="出品商品画像" />
            </div>    
            <div class="product-detail__text">
                <h3>商品名：{{ $product -> name }}</h3>
                <p>￥ {{ $product -> price }}</p>
            </div>
        </div>
        <div class="transaction-comment">
            <div class="transaction-other-comment">
                <div class="comment__container">
                    <div class="person__img">
                        <img class="person__img--item" src="{{ asset('storage/users/' . basename($product_user_profile -> image))  }}" alt="出品者画像" />
                    </div>
                    <div class="person__name">
                        <p>{{ $product_user -> name }}</p>
                    </div>
                </div>
                <div class="person__comment">
                    <input class="person__comment--text" type="text" readonly>
                </div>
            </div>
            <div class="transaction-my-comment">
                <div class="my-comment__container">
                    <div class="person__name">
                        <p>{{ $user -> name }}</p>
                    </div>
                    <div class="person__img">
                        <img class="person__img--item" src="{{ asset('storage/users/' . basename($user_profile -> image))  }}" alt="ユーザ画像" />
                    </div>
                </div>
                <div class="person__comment">
                    <input class="person__comment--text" type="text" readonly>
                    <div class="comment__button">
                        <button class="comment__button--submit" type="submit" name="revise">編集</button>
                        <button class="comment__button--submit" type="submit" name="del">削除</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="transaction-message__space">
            <input class="transaction-message__space--text" type="text" placeholder="取引メッセージを記入してください">
            <label class="transaction__image--button" for="image-upload">画像を追加</label>
            <input class="transaction__image--item" type="file" id="image-upload" name="image" accept="image/*" />
            <button class="transaction-send__button" type="submit">
                <img class="send__image--item" src="{{ asset('storage/logo/send.jpg') }}" alt="送信画像" />
            </button>
        </div>
    </div>
<div>

@endsection