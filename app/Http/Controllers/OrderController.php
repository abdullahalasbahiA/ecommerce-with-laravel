<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // if (auth()->user()->is_admin) {
            $payments = Payment::with(['user', 'items'])
                ->latest()
                ->paginate(10);
        // } else {
        //     $payments = auth()->user()->payments()
        //         ->with('items')
        //         ->latest()
        //         ->paginate(10);
        // }

        return view('orders.index', compact('payments'));
    }


    public function show(Payment $payment)
    {
        // Verify the payment belongs to the authenticated user
        if ($payment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('payment'));
    }
}
