<x-my-layout>
    <div class="container py-4">
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Order #{{ $payment->order_number }}</h2>
                <span class="badge 
                    @if($payment->payment_status == 'COMPLETED') badge-success
                    @elseif($payment->payment_status == 'PENDING') badge-warning
                    @else badge-danger
                    @endif">
                    {{ ucfirst(strtolower($payment->payment_status)) }}
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Order Details</h4>
                    <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                    <p><strong>Total:</strong> {{ $payment->currency }} {{ number_format($payment->amount, 2) }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
                </div>
                
                <div class="col-md-6">
                    <h4>Customer Details</h4>
                    {{-- @dd($payment) --}}
                    {{-- get the username using $payment->user_id --}}
                    <h1><span style="color: blue">USER NAME: </span>{{ \App\Models\User::find($payment->user_id)->name }}</h1>
                    <p style="color:red"><strong>UserID:</strong> {{ $payment->user_id }}</p>
                    <p><strong>Name:</strong> {{ $payment->payer_name }}</p>
                    <p><strong>Email:</strong> {{ $payment->payer_email }}</p>
                    @if($payment->shipping_address)
                        <p><strong>Shipping Address:</strong> {{ $payment->shipping_address }}</p>
                    @endif
                </div>
            </div>
            
            <hr>
            
            <h4>Order Items</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $payment->currency }} {{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $payment->currency }} {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="3" class="text-right">Grand Total:</td>
                        <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">
        Back to Orders
    </a>
</div>

</x-my-layout>