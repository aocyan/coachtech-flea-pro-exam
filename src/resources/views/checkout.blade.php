@extends('layouts.app')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@section('content')

<div class="main__header-logo">
    <h2>カード決済</h2>
</div>
<span class="caution--text">まだ、購入手続きは終わっていません</span>
<div class="howto__pay">
    <p class="howto__pay--text">　カードでお支払いをするには、下のカード情報欄に必要事項を入力し「決済を進める」ボタンを押してください。</p>
<div>
<form action="{{ route('charge') }}" id="payment-form" method="post">
@csrf
    <div class="form-group">
        <input type="hidden" name="pay" value="カード支払い" />
        <input type="hidden" name="price" value="{{ $product->price }}" />
        <div class="form__card">
            <p class="card--text">カード情報</p>
            <div id="card-element"></div>
        </div>
    </div>
    <button class="form-button" id="submit" >決済を進める</button>
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

        if (error) 
        {
            document.getElementById('error-message').textContent = error.message;
        } 
        else 
        {
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
                if (data.success) 
                {
                    window.location.href = successUrl; 
                }
                else 
                {
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

@endsection
