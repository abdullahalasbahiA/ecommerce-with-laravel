<x-my-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Orders</h1>

        @if ($payments->isEmpty())
            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg border border-blue-200">
                You haven't placed any orders yet.
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Order #</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Items</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $payment->order_number }}</td>
                                <td class="px-6 py-4">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ $payment->items->sum('quantity') }}</td>
                                <td class="px-6 py-4">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                                </td>
                                {{-- <td class="px-6 py-4">
                                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full
                                    @if ($payment->status === 'Completed') bg-green-100 text-green-700
                                    @elseif($payment->status === 'PENDING') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst(strtolower($payment->status->value)) }}
                                </span>
                            </td> --}}

                                <td>
                                    @if (auth()->id() == 3)
                                        <form action="{{ route('payments.updateStatus', $payment) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs rounded-md bg-gray-100 px-2 py-1 text-gray-700 border border-gray-300 focus:outline-none">
                                                @foreach (\App\Enums\PaymentStatus::cases() as $status)
                                                    <option value="{{ $status->value }}" @selected($payment->status === $status)>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @else
                                        {{-- <span
                                            class="inline-block text-xs font-semibold px-3 py-1 rounded-full
                                            @if ($payment->status->value === 'Completed') bg-green-100 text-green-700
                                            @elseif($payment->status->value === 'PENDING') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst(strtolower($payment->status->value)) }}
                                        </span> --}}
                                        <span
                                            class="inline-block text-xs font-semibold px-3 py-1 rounded-full {{ $payment->status->colorClass() }}">
                                            {{ ucfirst($payment->status->value) }}
                                        </span>
                                    @endif
                                </td>


                                <td class="px-6 py-4">
                                    <a href="{{ route('orders.show', $payment) }}"
                                        class="inline-block px-4 py-2 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $payments->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</x-my-layout>
