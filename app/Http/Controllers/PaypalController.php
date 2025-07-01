<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // $total_price = session('cart_data.total_price');
        // $items = [];

    }

    public function createPayment(Request $request)
    {
        // for multiple items
        // check the items that you might save in session
        // or in other ways

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // dd(session('cart'), session('cart_data'));

        $total_price = 0;
        foreach (session('cart') as $item) {
            $item_price = $item['price'] * $item['quantity'];
            $total_price += $item_price;
        }

        $items = [];

        foreach (session('cart') as $item) {
            $items[] = [
                "name" => $item["name"],
                "unit_amount" => [
                    "currency_code" => "USD",
                    "value" => $item["price"],
                ],
                "quantity" => $item["quantity"],
                "category" => "PHYSICAL_GOODS", // ✅ REQUIRED
            ];
        }

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $total_price, // Total value of all items
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => "USD",
                                "value" => $total_price, // Total value of all items
                            ],
                        ],
                    ],
                    "items" => [...$items],
                ],
            ],
        ]);


        // dd($response,session()->all());


        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    session()->put('product_name', $request->product_name);
                    session()->put('product_quantity', $request->quantity);
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        dd($response);
    }
    public function cancel() {}
}
