

// cart.js - Updated Version



// [Keep all your other functions exactly as they are...]

// alert('hello');

// Add to cart functionality
/*
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        addToCart(productId);
    });
});
*/



// Initialize cart when DOM loads
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("cart-items")) {
        loadCart();
    }
    updateCartCount();
});


// Add to cart functionality using event delegation
document.getElementById('results').addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
        const button = e.target.classList.contains('add-to-cart') 
        ? e.target 
        : e.target.closest('.add-to-cart');
        const productId = button.getAttribute('data-product-id');
        addToCart(productId);
        console.log(productId);
    }
});

// Cart functions
function addToCart(productId) {
    fetch("/store-cart/"+productId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                updateCartCount();
                showAlert("Product added to cart!", "success");
                loadCart();
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showAlert("Error adding product to cart", "danger");
        });
}

// Load cart on page load
document.addEventListener("DOMContentLoaded", function () {
    loadCart();
    updateCartCount();
});

function loadCart() {
    fetch("/fetch-cart")
        .then((response) => response.json())
        .then((cart) => {
            if (cart.empty) {
                document.getElementById("cart-items").innerHTML =
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
                        <div class="card mb-4 shadow-sm hover:shadow-md transition-shadow duration-200" data-product-id="${id}">
    <div class="card-body p-4 flex flex-col md:flex-row gap-4">
        <!-- Product Image -->
        <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 bg-gray-100 rounded-lg overflow-hidden">
            <img src="/storage/${item.image_url}" 
                 alt="${item.name}"
                 class="w-full h-full object-cover"
                 loading="lazy">
        </div>

        <!-- Product Details -->
        <div class="flex-grow">
            <div class="flex justify-between items-start">
                <!-- Product Name -->
                <h3 class="text-lg font-semibold text-gray-800 mb-1">${item.name}</h3>
                
                <!-- Remove Button -->
                <button class="remove-from-cart text-gray-400 hover:text-red-500 transition-colors"
                        data-product-id="${id}"
                        aria-label="Remove item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Price and Quantity -->
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <!-- Unit Price -->
                <span class="text-gray-600">$${item.price.toFixed(2)}</span>
                
                <!-- Quantity Selector -->
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">×</span>
                    <input type="number" 
                           min="1" 
                           value="${item.quantity}"
                           class="quantity-input border border-gray-300 rounded px-2 py-1 w-16 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Total Price -->
                <span class="ml-auto font-medium text-gray-900">$${itemTotal.toFixed(2)}</span>
            </div>
        </div>
    </div>
</div>
                    `;
            }

            cartItemsContainer.innerHTML = html;
            cartTotalElement.textContent = total.toFixed(2);

            // Add event listeners to the new elements
            document.querySelectorAll(".remove-from-cart").forEach((button) => {
                button.addEventListener("click", function () {
                    const productId = this.getAttribute("data-product-id");
                    removeFromCart(productId);
                });
            });

            document.querySelectorAll(".quantity-input").forEach((input) => {
                input.addEventListener("change", function () {
                    const productId = this.closest(".card").getAttribute("data-product-id");
                    console.log(productId);
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

function updateCartItem(productId, quantity) {
    console.log("Updating cart item:", productId, "Quantity:", quantity);
    if( quantity < 1) {
        quantity = 1; // Ensure quantity is at least 1
    }
    if (isNaN(quantity) || quantity <= 0) {
        quantity = 1;
    }
    fetch(`/store-cart/${productId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                loadCart();
                updateCartCount();
                showAlert("Cart updated!", "success");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showAlert("Error updating cart", "danger");
        });
}

function removeFromCart(productId) {
    fetch(`/store-cart/${productId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                updateCartCount();
                loadCart();
                showAlert("Product removed from cart!", "success");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showAlert("Error removing product from cart", "danger");
        });
}

function updateCartCount() {
    fetch("/fetch-cart")
        .then((response) => response.json())
        .then((cart) => {
            // if there is no items in the cart, set the count to 0
            if (cart.empty) {
                document.getElementById("cart-count").textContent = "0";
                return;
            }
            const count = Object.values(cart).reduce(
                (sum, item) => sum + item.quantity,
                0
            );
            document.getElementById("cart-count").textContent = count;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}


function showAlert(message, type) {
    const alert = document.createElement("div");
    alert.className = `alert alert-${type} position-fixed`;
    alert.style.top = "20px";
    alert.style.right = "20px";
    alert.style.zIndex = "2000";
    alert.textContent = message;

    document.body.appendChild(alert);

    setTimeout(() => {
        alert.remove();
    }, 250);
}
