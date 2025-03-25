@extends('layouts.app')

@section('content')

<form action="{{ route('charge') }}" method="post" id="payment-form" style="max-width: 500px; margin: 0 auto;">
@csrf
    <div class="form-group">
        <input type="hidden" name="pay" value="カード支払い" />
        <label for="card-element">カード情報</label>
            <div id="card-element">
            </div>
    </div>

            <button id="submit" class="btn btn-primary">決済を進める</button>
        <div id="error-message"></div>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();
        var successUrl = "{{ route('thanks') }}";

        var card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
    event.preventDefault();

    const {token, error} = await stripe.createToken(card);

    if (error) {
        document.getElementById('error-message').textContent = error.message;
    } 
    else {
        var formData = new FormData(form);
        formData.append('stripeToken', token.id);
        
        fetch("{{ route('charge') }}", {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log("Response data:", data);
            if (data.success) {
                window.location.href = successUrl; 
            } else {
                console.error("Payment failed:", data.error);
                alert('支払いに失敗しました。');
            }
        })
        .catch(function(error) {
            console.error("Request failed:", error);
        });
    }
});
    </script>

    <style>
        /* フォーム全体のスタイル */
        #payment-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* Stripe Elementsのカード入力フィールド */
        #card-element {
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
        }

        /* エラーメッセージの表示 */
        #error-message {
            color: red;
            margin-top: 10px;
        }

        /* 送信ボタンのスタイル */
        #submit {
            padding: 10px 20px;
            width: 100%;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        #submit:hover {
            background-color: #218838;
        }
    </style>
@endsection
