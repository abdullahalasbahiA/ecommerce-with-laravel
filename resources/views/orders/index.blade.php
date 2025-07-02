<x-my-layout>
<div class="container py-4">
    <h1 class="mb-4">My Orders</h1>
    
    @if($payments->isEmpty())
        <div class="alert alert-info">You haven't placed any orders yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->order_number }}</td>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td>{{ $payment->items->sum('quantity') }}</td>
                        <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($payment->payment_status == 'COMPLETED') badge-success
                                @elseif($payment->payment_status == 'PENDING') badge-warning
                                @else badge-danger
                                @endif">
                                {{ ucfirst(strtolower($payment->payment_status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $payment) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links() }}
        </div>
    @endif
</div>
</x-my-layout>
