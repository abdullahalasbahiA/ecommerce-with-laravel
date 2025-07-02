<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;
use App\Models\PaymentItem; // Make sure you create this model
use Illuminate\Support\Facades\DB; // For database transactions

class PaypalController extends Controller
{
    /**
     * Initialize PayPal payment process
     */
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        // This method might be used for single product payments
        // For multiple products, we'll use createPayment
    }

    /**
     * Create a PayPal order with multiple products
     */
    public function createPayment(Request $request)
    {
        // Validate that cart exists and has items
        if (!session()->has('cart') || count(session('cart')) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Calculate total price and prepare items array
        $total_price = 0;
        $items = [];

        foreach (session('cart') as $item) {
            // Validate each item has required fields
            if (!isset($item['name'], $item['price'], $item['quantity'])) {
                continue; // or handle error
            }

            $item_price = $item['price'] * $item['quantity'];
            $total_price += $item_price;

            // Prepare items for PayPal request
            $items[] = [
                "name" => $item["name"],
                "unit_amount" => [
                    "currency_code" => "USD",
                    "value" => $item["price"],
                ],
                "quantity" => $item["quantity"],
                "category" => "PHYSICAL_GOODS",
            ];
        }

        // Store all cart items in session for later use in success method
        session()->put('cart_items', session('cart'));

        // Create PayPal order
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
                        "value" => $total_price,
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => "USD",
                                "value" => $total_price,
                            ],
                        ],
                    ],
                    "items" => [...$items], // Spread operator to include all items
                ],
            ],
        ]);

        // Handle PayPal response
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('cancel')->with('error', 'Failed to create PayPal order');
    }

    /**
     * Handle successful PayPal payment
     */
public function success(Request $request)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();
    
    try {
        $response = $provider->capturePaymentOrder($request->token);

        // Verify we have cart items in session
        if (!session()->has('cart_items')) {
            return redirect()->route('cancel')->with('error', 'Session expired - please try your order again');
        }

        return DB::transaction(function () use ($response) {
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Get first product name for the payment record (or concatenate all)
                $firstProduct = session('cart_items')[0]['name'] ?? 'Multiple Products';
                $totalQuantity = array_sum(array_column(session('cart_items'), 'quantity'));

                // 1. Create the main payment record
                $payment = Payment::create([
                    'payment_id' => $response['id'],
                    // payer id in my website database
                    // 'user_web_id' => auth()->id, // Assuming user is authenticated
                    // payer name in my website database
                    // 'user_name' => auth()->user()->name ?? 'Guest',
                    // payer email in my website database
                    // 'user_email' => auth()->user()->email ?? '',
                    'payer_id' => $response['payer']['payer_id'],
                    'payer_email' => $response['payer']['email_address'],
                    'product_name' => $firstProduct, // Provide a value for this required field
                    'quantity' => $totalQuantity, // Provide a value for this required field
                    'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                    'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                    'payer_name_gateway' => $response['payer']['name']['given_name'] . ' ' . ($response['payer']['name']['surname'] ?? ''),
                    'payer_email_gateway' => $response['payer']['email_address'],
                    'payment_status' => $response['status'],
                    'payment_method' => 'PayPal',
                    'paid_at' => now(),
                ]);

                // 2. Create payment items for each product
                foreach (session('cart_items') as $item) {
                    PaymentItem::create([
                        'payment_id' => $payment->id,
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['price'] * $item['quantity'],
                    ]);
                }

                // 3. Clear the cart session
                session()->forget(['cart', 'cart_items']);

                // 4. Return success response
                return view('payment.success', [
                    'payment' => $payment,
                    'items' => $payment->items
                ]);
            }

            return redirect()->route('cancel')->with('error', 'Payment not completed');
        });
    } catch (\Exception $e) {
        \Log::error('PayPal payment error: ' . $e->getMessage());
        return redirect()->route('cancel')->with('error', 'Error processing payment');
    }
}

    /**
     * Handle cancelled PayPal payment
     */
    public function cancel()
    {
        // Optionally keep cart items if payment was cancelled
        // session()->forget('cart_items'); // Uncomment if you want to clear on cancel
        
        return view('payment.cancel');
    }
}