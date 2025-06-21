



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
// Add to cart functionality using event delegation
document.getElementById('results').addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
        const button = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest('.add-to-cart');
        const productId = button.getAttribute('data-product-id');
        addToCart(productId);
        console.log(productId);
    }
});



// Cart functions
function addToCart(productId) {
    fetch("/store-cart", {
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
                        <div class="card mb-3" data-product-id="${id}">
                            <div class="card-body">
                             <img style="width:auto; height: 50px" src="/storage/${item.image_url}"
                    class="absolute h-full "
                    loading="lazy"
                >
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
                button.addEventListener("click", function () {
                    const productId = this.getAttribute("data-product-id");
                    removeFromCart(productId);
                });
            });

            document.querySelectorAll(".quantity-input").forEach((input) => {
                input.addEventListener("change", function () {
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

function updateCartItem(productId, quantity) {
    fetch(`/store-cart/${productId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({
            quantity: quantity,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                updateCartCount();
                loadCart();
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
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
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
