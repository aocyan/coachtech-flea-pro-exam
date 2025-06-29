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
                <p>ユーザ画像</p>
            </div>
            <div class="transaction-header__logo">
                <h2>「ユーザ名」さんとの取引画面</h2>
            </div>
            <div class="transaction-button">
                <button class="transaction-button--text">取引を完了する</button>
            </div>
        </div>
        <div class="product-detail">
            <div class="product-detail__img">
                <p>商品イメージ画像</p>
            </div>    
            <div class="product-detail__text">
                <h2>商品名</h2>
                <p>商品価格</p>
            </div>
        </div>
        <div class="transaction-comment">
            <div class="transaction-other-comment">
                <div class="comment__container">
                    <div class="other-person__img">
                        <p>ユーザ画像</p>
                    </div>
                    <div class="other-person__name">
                        <p>ユーザ名</p>
                    </div>
                </div>
                <div class="other-person__comment">
                    <input class="other-person__comment--text" type="text" placeholder="相手のコメント">
                </div>
            </div>
            <div class="transaction-my-comment">
                <div class="comment__container">
                    <div class="my__img">
                        <p>ユーザ名</p>
                    </div>
                    <div class="my__name">
                        <p>ユーザ画像</p>
                    </div>
                </div>
                <div class="my__comment">
                    <input class="other-person__comment--text" type="text" placeholder="自分のコメント">
                    <div class="comment__button">
                        <button>編集</button>
                        <button>削除</button>
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