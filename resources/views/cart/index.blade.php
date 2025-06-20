<x-my-layout>

    <div class="container py-5">
        <h1 class="mb-4">Products</h1>
        

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Cart Sidebar -->
    <div class="cart-overlay" id="cart-overlay"></div>
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Your Cart</h3>
            <button class="btn-close" id="close-cart"></button>
        </div>
        
        <div id="cart-items">
            <!-- Cart items will be loaded here via AJAX -->
            <p>Your cart is empty</p>
        </div>
        
        <div class="mt-4">
            <h5>Total: $<span id="cart-total">0.00</span></h5>
            <button class="btn btn-success w-100 mt-3">Checkout</button>
        </div>
    </div>
    
</x-my-layout>
