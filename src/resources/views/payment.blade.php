@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')

<div class="main__header-logo">
    <h2>コンビニ決済</h2>
</div>
<span class="caution--text">まだ、購入手続きは終わっていません</span>
<div class="howto__pay">
    <p class="howto__pay--text">　コンビニでお支払いをするには、下のボタンを押してお支払いするコンビニを選択し、支払い手順をご確認の上お支払いください。
    </p>
    <button class="howto__pay--button" id="payButton">コンビニ決済を行う</button>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');

    document.getElementById('payButton').addEventListener('click', function() {
        var paymentIntentUrl = "{{ route('charge') }}";
        var successUrl = "{{ route('thanks') }}";
        var pay = "コンビニ払い";
        var userName = "{{ $user->name }}";
        var userEmail = "{{ $user->email }}";
        var productPrice = @json($product->price);

        fetch(paymentIntentUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                price: productPrice,
                pay: pay
            }),
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            var clientSecret = data.clientSecret;

            stripe.createPaymentMethod('konbini', {
                billing_details: {
                    name: userName,
                    email: userEmail,
                }
            }).then(function(result) {
                if (result.error) {
                    console.log('支払い方法の作成に失敗しました:', result.error.message);
                    alert('支払い方法の作成に失敗しました');
                    return;
            }

            var paymentMethodId = result.paymentMethod.id;

                stripe.confirmPayment({
                    clientSecret: clientSecret,
                    paymentMethod: paymentMethodId, 
                    confirmParams: { return_url: successUrl }
                })
                .then(function(result) {
                    if (result.error) {
                        console.error("決済に失敗しました: ", result.error);
                        alert("決済に失敗しました: " + result.error.message);
                    } else if (result.paymentIntent.status === 'requires_action') {
                        alert('支払いが完了するまで、追加のアクションが必要です。');
                        if (result.paymentIntent.next_action) {
                            var actionUrl = result.paymentIntent.next_action.redirect_to_url.url;
                            console.log("Redirecting to URL:", actionUrl); 
                            window.location.href = actionUrl;
                        }
                    } else if (result.paymentIntent.status === 'succeeded') {
                        alert("決済が完了しました!");
                    }
                });
            });
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('決済情報の取得に失敗しました');
        });
    });
</script>

@endsection
