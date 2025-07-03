<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $query = Payment::query()->with('items');

        if (auth()->id() == 3) {
            // Admin sees all payments with user relationships
            $query->with('user')->latest();
        } else {
            // Regular users see only their payments
            $query->where('user_id', auth()->id())->latest();
        }

        $payments = $query->paginate(10);

        return view('orders.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        // Verify the payment belongs to the authenticated user
        if ($payment->user_id !== auth()->id() && auth()->id() != 3) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(PaymentStatus::cases(), 'value'))],
        ]);

        $payment->status = PaymentStatus::from($request->status);
        $payment->save();

        return redirect()->back()->with('success', 'Payment status updated.');
    }
}
