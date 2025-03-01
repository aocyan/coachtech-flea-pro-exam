@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
<div class="sell-header">
    <div class="sell-header__logo">
        <h2>商品の出品</h2>
    </div>
</div>
<form class="sell-form" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data">
@csrf
    <div class="form__group">
        <div class="image__logo">
            <p>商品画像</p>
        </div>
        <div class="image__frame">
            <label class="form__image--button" for="image-upload">画像を選択する</label>
            <input class="form__image--item" type="file" id="image-upload" name="image" accept="image/*" />
        </div>
        <div class="form__group-title">
            <p>商品の詳細</p>
        </div>
        <div class="group__logo">
            <p>カテゴリー</p>
        </div>
        <div class="category__list">
            <div class="cattegory__container-up">
                <input class="category__check" type="checkbox" name="category[]" id="fassion" value="ファッション" />
                <label class="category__button" for="fassion">ファッション</label>
                <input class="category__check" type="checkbox" name="category[]" id="appliance" value="家電" />
                <label class="category__button" for="appliance">家電</label>
                <input class="category__check" type="checkbox" name="category[]" id="interior" value="インテリア" />
                <label class="category__button" for="interior">インテリア</label>
                <input class="category__check" type="checkbox" name="category[]" id="womens" value="レディース" />
                <label class="category__button" for="womens">レディース</label>
                <input class="category__check" type="checkbox" name="category[]" id="mens" value="メンズ" />
                <label class="category__button" for="mens">メンズ</label>
                <input class="category__check" type="checkbox" name="category[]" id="cosmetic" value="コスメ" />
                <label class="category__button" for="cosmetic">コスメ</label>
            </div>
            <div class="category__container-center">
                <input class="category__check" type="checkbox" name="category[]" id="book" value="本" />
                <label class="category__button" for="book">本</label>
                <input class="category__check" type="checkbox" name="category[]" id="game" value="ゲーム" />
                <label class="category__button" for="game">ゲーム</label>
                <input class="category__check" type="checkbox" name="category[]" id="sport" value="スポーツ" />
                <label class="category__button" for="sport">スポーツ</label>
                <input class="category__check" type="checkbox" name="category[]" id="kitchen" value="キッチン" />
                <label class="category__button" for="kitchen">キッチン</label>
                <input class="category__check" type="checkbox" name="category[]" id="handmade" value="ハンドメイド" />
                <label class="category__button" for="handmade">ハンドメイド</label>
                <input class="category__check" type="checkbox" name="category[]" id="accessory" value="アクセサリー" />
                <label class="category__button" for="accessory">アクセサリー</label>
            </div>
            <div class="category__container-down">
                <input class="category__check" type="checkbox" name="category[]" id="toy" value="おもちゃ" />
                <label class="category__button" for="toy">おもちゃ</label>
                <input class="category__check" type="checkbox" name="category[]" id="kids" value="ベビー・キッズ" />
                <label class="category__button" for="kids">ベビー・キッズ</label>
            </div>
        </div>
        <div class="group__logo">
            <p>商品の状態</p>
        </div>
        <select class="condition__select" name="condition" >
			<option class="select--option" disabled selected>選択してください</option>
			<option class="select--option" value="良好">良好</option>
			<option class="select--option" value="目立った傷や汚れなし">目立った傷や汚れなし</option>
			<option class="select--option" value="やや傷や汚れあり">やや傷や汚れあり</option>
			<option class="select--option" value="状態が悪い">状態が悪い</option>
        </select>
        <div class="form__group-title">
            <p>商品名と説明</p>
        </div>
        <div class="group__logo">
            <p>商品名</p>
        </div>
        <input class="form__input" type="text" name="name" value=""/>
        <div class="form__error">
            @error('name')
                {{ $message }}
            @enderror
        </div>
        <div class="group__logo">
            <p>ブランド名</p>
        </div>
        <input class="form__input" type="text" name="brand" value=""/>
        <div class="form__error">
            @error('brand')
                {{ $message }}
            @enderror
        </div>
        <div class="group__logo">
            <p>カラー</p>
        </div>
        <input class="form__input" type="text" name="color" value=""/>
        <div class="form__error">
            @error('color')
                {{ $message }}
            @enderror
        </div>
        <div class="group__logo">
            <p>商品の説明</p>
        </div>
        <div class="form__textarea">
			<textarea class="form__textarea--text" name="detail"></textarea>
		</div>
        <div class="form__error">
            @error('detail')
                {{ $message }}
            @enderror
        </div>
        <div class="group__logo">
            <p>販売価格</p>
        </div>
        <input class="form__input" type="text" name="price" value="￥"/>
        <div class="form__error">
            @error('price')
                {{ $message }}
            @enderror
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="back" value="back">出品する</button>
        </div>
    </div>
</form>

@endsection