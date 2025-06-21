<x-my-layout>

    <div class="container py-5">
        <h1 class="mb-4">The Cart Items</h1>

        <div class="row">
            {{-- @foreach ($products as $product)
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
            @endforeach --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
        });

        function loadCart() {
            fetch("/carts")
                .then((response) => response.json())
                .then((cart) => {
                    if (cart.empty) {
                        document.getElementById("cart-cart").innerHTML =
                            "<p>Your cart is empty</p>";
                        document.getElementById("cart-total").textContent = "0.00";
                        document.getElementById("checkout-button").disabled = true;
                        return;
                    }

                    const cartItemsContainer = document.getElementById("cart-items");
                    const cartTotalElement = document.getElementById("cart-total");

                    if (Object.keys(cart).length === 0) {
                        cartItemsContainer.innerHTML = "<p>Your cart is empty</p>";
                        cartTotalElement.textContent = "0.00";
                        return;
                    }

                    let html = "";
                    let total = 0;

                    for (const [id, item] of Object.entries(cart)) {
                        const itemTotal = item.price * item.quantity;
                        total += itemTotal;

                        html += `
                        <div class="card mb-3" data-product-id="${id}">
                            <div class="card-body">
                                <div class="relative pb-[78%] overflow-hidden">
                <img 
                    src="/storage/${item.image}"
                    alt="${product.name}"
                    class="absolute h-full w-full "
                    loading="lazy"
                >
            </div>
                                <div class="d-flex justify-content-between">
                                    <h5>${item.name}</h5>
                                    <button class="btn-close remove-from-cart" data-product-id="${id}"></button>
                                </div>
                                <p>$${item.price.toFixed(2)} x 
                                <input type="number" min="1" value="${
                                    item.quantity
                                }" class="quantity-input" style="width: 60px;">
                                = $${itemTotal.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                    }


                    

                    cartItemsContainer.innerHTML = html;
                    cartTotalElement.textContent = total.toFixed(2);

                    // Add event listeners to the new elements
                    document.querySelectorAll(".remove-from-cart").forEach((button) => {
                        button.addEventListener("click", function() {
                            const productId = this.getAttribute("data-product-id");
                            removeFromCart(productId);
                        });
                    });

                    document.querySelectorAll(".quantity-input").forEach((input) => {
                        input.addEventListener("change", function() {
                            const productId =
                                this.closest(".card").getAttribute("data-product-id");
                            const newQuantity = parseInt(this.value);
                            updateCartItem(productId, newQuantity);
                        });
                    });
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showAlert("Error loading cart", "danger");
                });
        }
    </script>
</x-my-layout>
