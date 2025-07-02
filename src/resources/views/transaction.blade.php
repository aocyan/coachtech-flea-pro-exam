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
        @foreach($products as $product)
            <div class="other-transaction__link">
                <a class="other-transaction__link--button" href="{{ route('transaction.index', $product->id) }}"">{{ $product -> name }}</a>
            </div>
        @endforeach
    </div>
    <div class="right__box">
        <div class="transaction-header">
            @if($user -> id !== $product -> product_user_id)
            <div class="transaction-header__img">
                <img class="header__img--item" src="{{ asset('storage/users/' . basename($product_user_profile -> image))  }}" alt="出品者画像" />
            </div>
            <div class="transaction-header__logo">
                <h2>「{{ $product_user -> name }}」さんとの取引画面</h2>
            </div>
            @else
            <div class="transaction-header__img">
                <img class="header__img--item" src="{{ asset('storage/users/' . basename($transaction_user_profile -> image))  }}" alt="出品者画像" />
            </div>
            <div class="transaction-header__logo">
                <h2>「{{ $transaction_user -> name }}」さんとの取引画面</h2>
            </div>
            @endif
            @if($user -> id !== $product -> product_user_id)
            <div class="transaction-button">
                <button type="button" class="transaction__link--button" id="completion">取引を完了する</button>
            </div>
            @endif
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
            @foreach($other_comments as $other_comment)
                <div class="transaction-other-comment">
                    @if($other_comment -> comment)
                    <div class="comment__container">
                        <div class="person__img">
                            <img class="person__img--item" src="{{ asset('storage/users/' . basename($other_comment -> user -> profile -> image))  }}" alt="相手画像" />
                        </div>
                        <div class="person__name">
                            <p>{{ $other_comment -> user -> name }}</p>
                        </div>
                    </div>                 
                    <div class="person__comment">
                        <textarea class="person__comment--text" type="text" readonly>{{ $other_comment -> comment }}</textarea>
                    </div>
                    @endif
                    @if($other_comment -> image))
                        <div class="person__comment">
                            <img class="comment__img--item" src="{{ asset('storage/transactions/' . basename($other_comment -> image))  }}" alt="コメント画像" />
                        </div>
                    @endif
                </div>
            @endforeach
            <form action="{{ route('transaction.edit', ['item_id' => $item_id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @foreach($user_comments as $user_comment)
                <div class="transaction-my-comment">
                    @if($user_comment -> comment)
                    <div class="my-comment__container">
                        <div class="person__name">
                            <p>{{ $user -> name }}</p>
                        </div>
                        <div class="person__img">
                            <img class="person__img--item" src="{{ asset('storage/users/' . basename($user_profile -> image))  }}" alt="ユーザ画像" />
                        </div>
                    </div>
                    <div class="person__comment">
                        <textarea class="person__comment--text" type="text" name="comment[{{ $user_comment -> id }}]" >{{ $user_comment -> comment }}</textarea>
                        <div class="comment__button">
                            <button class="comment__button--submit" type="submit" name="revise_comment">編集</button>
                            <button class="comment__button--submit" type="submit" name="del_comment" value="{{ $user_comment -> id }}">削除</button>
                        </div>
                    </div>
                    @endif
                    @if(isset($user_comment -> image))
                        <div class="person__comment">
                            <img class="comment__img--item" src="{{ asset('storage/transactions/' . basename($user_comment -> image))  }}" alt="コメント画像" />
                            <div class="comment__button">
                                <button class="comment__button--submit" type="submit" name="del_img" value="{{ $user_comment -> id }}">削除</button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            </form>
        </div>
        <form action="{{ route('transaction.store', ['item_id' => $item_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="transaction-message__space">
                <input class="transaction-message__space--text" type="text" name="comment" placeholder="取引メッセージを記入してください">
                <label class="transaction__image--button" for="image-upload">画像を追加</label>
                <input class="transaction__image--item" type="file" id="image-upload" name="image" accept="image/*" />
                <button class="transaction-send__button" type="submit">
                    <img class="send__image--item" src="{{ asset('storage/logo/send.jpg') }}" alt="送信画像" />
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-content" id="message">
    <div class="modal-header">
        <h3 class="modal-title">取引が完了しました。</h5>
    </div>
    <div class="modal__text">
        <p class="modal__text--sentence">今回の取引相手はどうでしたか？</p>
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
    <div class="modal__link">
        <a class="modal__link--button" href="{{ route('purchase.index', ['item_id'=> $product->id]) }}">送信する</a>
    </div>
</div>

<script>
    document.getElementById("completion").addEventListener("click", function () {
        document.getElementById("message").style.display = "block";
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector(".evaluation__container");
        const inputs = container.querySelectorAll(".category__check");
        const labels = container.querySelectorAll(".category__button");

        container.addEventListener("click", function (e) {
            if (e.target.tagName === "LABEL") {
                const label = e.target;
                const clickedIndex = parseInt(label.dataset.index);

                inputs.forEach((input, index) => {
                    input.checked = index === clickedIndex;
                });

                labels.forEach((label, index) => {
                    if (index <= clickedIndex) {
                        label.classList.add("active");
                    } else {
                        label.classList.remove("active");
                    }
                });
            }
        });
    });
</script>

@endsection