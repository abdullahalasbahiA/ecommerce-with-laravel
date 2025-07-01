<x-my-layout>
    <div class="container py-5">
        <h1 class="mb-4">Your Shopping Cart</h1>
        
        <!-- Main Cart Content -->
        <div id="cart-items">
            <!-- Will be populated by JavaScript -->
            <p>Loading your cart...</p>
        </div>
        
        <div class="mt-4">
            <h5>Total: $<span id="cart-total">0.00</span></h5>
            <form action="{{route('createpayment')}}" method="post">
                @csrf
                <button id="checkout-button" class="btn btn-success w-100 mt-3">Proceed to Checkout</button>
            </form>
        </div>
    </div>
</x-my-layout>

