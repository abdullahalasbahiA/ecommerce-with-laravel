<x-my-layout>
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-6">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 border-b border-gray-200 bg-gradient-to-r from-white via-gray-50 to-white">
                <h2 class="text-xl font-bold text-gray-800">
                    Order #{{ $payment->order_number }}
                </h2>
                <span
                    class="inline-block font-semibold px-4 py-1 rounded-full {{ $payment->status->colorClass() }}">
                    {{ ucfirst($payment->status->value) }}
                </span>
            </div>

            <div class="p-6 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-4">Order Details</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li><span class="font-medium w-28 inline-block">Date:</span>
                                {{ $payment->created_at->format('M d, Y h:i A') }}</li>
                            <li><span class="font-medium w-28 inline-block">Total:</span> {{ $payment->currency }}
                                {{ number_format($payment->amount, 2) }}</li>
                            <li><span class="font-medium w-28 inline-block">Method:</span>
                                {{ ucfirst($payment->payment_method) }}</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-4">Customer Details</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li><span class="font-medium w-28 inline-block">Name:</span>
                                {{ $payment->user->name ?? 'N/A' }}</li>
                            <li><span class="font-medium w-28 inline-block">Email:</span> {{ $payment->payer_email }}
                            </li>
                            @if ($payment->shipping_address)
                                <li><span class="font-medium w-28 inline-block">Shipping:</span>
                                    {{ $payment->shipping_address }}</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-4">Order Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-slate-700 border border-gray-200 rounded-lg">
                            <thead class="bg-slate-100 text-slate-600 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->items as $item)
                                    <tr class="border-t border-gray-200">
                                        <td class="px-4 py-2">{{ $item->product_name }}</td>
                                        <td class="px-4 py-2">{{ $payment->currency }}
                                            {{ number_format($item->price, 2) }}</td>
                                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="px-4 py-2">{{ $payment->currency }}
                                            {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-slate-50 font-semibold border-t border-gray-300">
                                    <td colspan="3" class="text-right px-4 py-3">Grand Total:</td>
                                    <td class="px-4 py-3">{{ $payment->currency }}
                                        {{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition">
                ← Back to Orders
            </a>
        </div>
    </div>
</x-my-layout>
