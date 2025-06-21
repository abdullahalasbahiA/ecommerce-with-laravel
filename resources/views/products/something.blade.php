<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background: #fff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            padding: 20px;
            z-index: 1000;
            overflow-y: auto;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .cart-overlay.open {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>
                    62,622.74
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        @endauth
        <h1 class="mb-4">Products</h1>

        <button id="cart-toggle" class="btn btn-primary position-fixed" style="top: 20px; right: 20px; z-index: 100;">
            Cart (<span id="cart-count">0</span>)
        </button>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" class="card-img-top"
                            alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">Add to
                                Cart</button>
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
            {{-- <button class="btn btn-success w-100 mt-3">Checkout</button> --}}
            <button class="btn btn-success w-100 mt-3" id="checkout-button">Proceed to PayPal Checkout</button>
        </div>
    </div>

    <script>
        // =====================================================================
        // ========================== PAYPAL CHECKOUT ==========================
        // =====================================================================
        // Add this to your existing JavaScript in products/index.blade.php
        document.getElementById('checkout-button').addEventListener('click', function() {
            const button = this;
            button.disabled = true;
            button.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            fetch('/handle-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        return_url: window.location.origin + '/payment/success',
                        cancel_url: window.location.origin + '/payment/cancel'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        showAlert(data.message || 'Error processing payment', 'danger');
                        if (data.details) {
                            console.error('PayPal Error Details:', data.details);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error processing payment: ' + error.message, 'danger');
                })
                .finally(() => {
                    button.disabled = false;
                    button.textContent = 'Proceed to PayPal Checkout';
                });
        });


        // Toggle cart visibility
        document.getElementById('cart-toggle').addEventListener('click', function() {
            document.getElementById('cart-sidebar').classList.add('open');
            document.getElementById('cart-overlay').classList.add('open');
            loadCart();
        });

        document.getElementById('close-cart').addEventListener('click', function() {
            document.getElementById('cart-sidebar').classList.remove('open');
            document.getElementById('cart-overlay').classList.remove('open');
        });

        document.getElementById('cart-overlay').addEventListener('click', function() {
            document.getElementById('cart-sidebar').classList.remove('open');
            this.classList.remove('open');
        });

        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                addToCart(productId);
            });
        });

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        // Cart functions
        function addToCart(productId) {
            fetch('/store-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        showAlert('Product added to cart!', 'success');
                        loadCart()
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error adding product to cart', 'danger');
                });
        }

        function loadCart() {
            fetch('/fetch-cart')
                .then(response => response.json())
                .then(cart => {
                    if (cart.empty) {
                        document.getElementById('cart-items').innerHTML = '<p>Your cart is empty</p>';
                        document.getElementById('cart-total').textContent = '0.00';
                        document.getElementById('checkout-button').disabled = true;
                        return;
                    }

                    const cartItemsContainer = document.getElementById('cart-items');
                    const cartTotalElement = document.getElementById('cart-total');

                    if (Object.keys(cart).length === 0) {
                        cartItemsContainer.innerHTML = '<p>Your cart is empty</p>';
                        cartTotalElement.textContent = '0.00';
                        return;
                    }

                    let html = '';
                    let total = 0;

                    for (const [id, item] of Object.entries(cart)) {
                        const itemTotal = item.price * item.quantity;
                        total += itemTotal;

                        html += `
                        <div class="card mb-3" data-product-id="${id}">
                            <div class="card-body">
                                <img 
                    src="/storage/${item.image_url}"
                    class="absolute h-full "
                    loading="lazy"
                >
                                <div class="d-flex justify-content-between">
                                    <h5>${item.name}</h5>
                                    <button class="btn-close remove-from-cart" data-product-id="${id}"></button>
                                </div>
                                <p>$${item.price.toFixed(2)} x 
                                <input type="number" min="1" value="${item.quantity}" class="quantity-input" style="width: 60px;">
                                = $${itemTotal.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                    }

                    cartItemsContainer.innerHTML = html;
                    cartTotalElement.textContent = total.toFixed(2);

                    // Add event listeners to the new elements
                    document.querySelectorAll('.remove-from-cart').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = this.getAttribute('data-product-id');
                            removeFromCart(productId);
                        });
                    });

                    document.querySelectorAll('.quantity-input').forEach(input => {
                        input.addEventListener('change', function() {
                            const productId = this.closest('.card').getAttribute('data-product-id');
                            const newQuantity = parseInt(this.value);
                            updateCartItem(productId, newQuantity);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error loading cart', 'danger');
                });
        }

        function updateCartItem(productId, quantity) {
            fetch(`/store-cart/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        loadCart();
                        showAlert('Cart updated!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error updating cart', 'danger');
                });
        }

        function removeFromCart(productId) {
            fetch(`/store-cart/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        loadCart();
                        showAlert('Product removed from cart!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error removing product from cart', 'danger');
                });
        }

        function updateCartCount() {
            fetch('/fetch-cart')
                .then(response => response.json())
                .then(cart => {
                    // if there is no items in the cart, set the count to 0
                    if (cart.empty) {
                        document.getElementById('cart-count').textContent = '0';
                        return;
                    }
                    const count = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
                    document.getElementById('cart-count').textContent = count;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} position-fixed`;
            alert.style.top = '20px';
            alert.style.right = '20px';
            alert.style.zIndex = '2000';
            alert.textContent = message;

            document.body.appendChild(alert);

            setTimeout(() => {
                alert.remove();
            }, 250);
        }
    </script>
</body>

</html>
