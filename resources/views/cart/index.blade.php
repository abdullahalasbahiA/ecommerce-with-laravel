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
    
    <script>
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

        
        function loadCart() {
            fetch('/cart')
            .then(response => response.json())
            .then(cart => {
                const cartItemsContainer = document.getElementById('cart-items');
                const cartTotalElement = document.getElementById('cart-total');
                
                if(Object.keys(cart).length === 0) {
                    cartItemsContainer.innerHTML = '<p>Your cart is empty</p>';
                    cartTotalElement.textContent = '0.00';
                    return;
                }
                
                let html = '';
                let total = 0;
                
                for(const [id, item] of Object.entries(cart)) {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    
                    html += `
                        <div class="card mb-3" data-product-id="${id}">
                            <div class="card-body">
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
            fetch(`/cart/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
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
            fetch(`/cart/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
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
            fetch('/cart')
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
            }, 3000);
        }
    </script>

</x-my-layout>
