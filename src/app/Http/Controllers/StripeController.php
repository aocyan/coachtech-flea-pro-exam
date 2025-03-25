<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function checkout()
    {
        $user = Auth()->user();
        $product = session('product');

        return view('checkout',compact('user','product'));
    }

    public function payment()
    {
        $user = Auth()->user();
        $product = session('product');

        return view('payment',compact('user','product'));
    }

    public function charge(Request $request)
    {
        $paymentMethod = $request->input('pay');

        if($paymentMethod === 'カード支払い')
        {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $customer = Customer::create([
                    'email' => $request->stripeEmail,
                    'source' => $request->stripeToken,
                ]);

                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => 1000,
                    'currency' => 'jpy',
                ]);

                return response()->json(['success' => true]);
            } 
            catch (\Exception $ex) 
            {
                return response()->json(['error' => $ex->getMessage()]);
            }
        }

        if($paymentMethod === 'コンビニ払い')
        {
           Stripe::setApiKey(env('STRIPE_SECRET'));
           $user = Auth()->user();

           $billingDetails = [
                'name' => $user-> name,  
                'email' => $user-> email,
           ]; 

           $paymentMethod = PaymentMethod::create([
                'type' => 'konbini',
                'billing_details' => $billingDetails,
            ]);

            $paymentIntent = PaymentIntent::create([
                'amount' => 1000,
                'currency' => 'jpy',
                'payment_method_types' => ['konbini'],
                'confirm' => 'false',
                'confirmation_method'=> 'automatic',
            ]);

            PaymentIntent::update($paymentIntent->id, [
                'payment_method' => $paymentMethod->id,
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]); 
        }
    }

    public function thanks()
    {
        $user = Auth()->user();

        return view('thanks',compact('user'));
    }
}
