class Cart {
    static baseUrl = '/cart';
    static headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
    };

    static async add(productId, quantity = 1) {
        return this._sendRequest('add', { product_id: productId, quantity });
    }

    static async update(productId, quantity) {
        return this._sendRequest('update', { product_id: productId, quantity });
    }

    static async remove(productId) {
        return this._sendRequest('remove', { product_id: productId });
    }

    static async _sendRequest(action, data) {
        try {
            const response = await fetch(`${this.baseUrl}/${action}`, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify(data)
            });

            return await response.json();
        } catch (error) {
            console.error('Cart error:', error);
            return { success: false, message: 'Network error' };
        }
    }

    static updateUI(response) {
        if (response.cart_count !== undefined) {
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = response.cart_count;
                el.classList.toggle('hidden', response.cart_count === 0);
            });
        }
        
        if (response.message) {
            this.showToast(response.message);
        }
    }

    static showToast(message) {
        // Implement your notification system
        console.log(message); // Replace with actual UI notification
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.dataset.productId;
            const response = await Cart.add(productId);
            Cart.updateUI(response);
        });
    });
});


// Add to cart.js
document.addEventListener('DOMContentLoaded', () => {
    // Quantity updates
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async (e) => {
            const response = await Cart.update(
                e.target.dataset.productId, 
                parseInt(e.target.value)
            );
            Cart.updateUI(response);
        });
    });

    // Remove items
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const response = await Cart.remove(e.target.dataset.productId);
            Cart.updateUI(response);
            e.target.closest('.border-b').remove();
        });
    });
});





/*

From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION
From AI HERE might be alot of redundant code, THIS IS NOT THE FINAL VERSION

*/



document.addEventListener('DOMContentLoaded', function() {
    // Update quantity and prices when input changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async function() {
            const productId = this.dataset.productId;
            const newQuantity = parseInt(this.value);
            
            if (newQuantity < 1) {
                this.value = 1;
                return;
            }

            // Update UI immediately
            const itemElement = this.closest('.cart-item');
            const price = parseFloat(itemElement.querySelector('.text-gray-600').textContent.replace('$', ''));
            const itemTotal = price * newQuantity;
            
            itemElement.querySelector('.item-total').textContent = '$' + itemTotal.toFixed(2);
            itemElement.querySelector('.quantity-display').textContent = newQuantity;
            
            // Update cart total
            updateCartTotal();
            
            // Send update to server
            try {
                const response = await fetch('/cart/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQuantity
                    })
                });
                
                const data = await response.json();
                if (!data.success) {
                    console.error('Update failed:', data.message);
                    // Optionally revert UI changes
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Calculate and update cart total
    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseFloat(item.querySelector('.text-gray-600').textContent.replace('$', ''));
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            total += price * quantity;
        });
        
        document.getElementById('cart-total').textContent = total.toFixed(2);
    }

    // Remove item functionality
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            const itemElement = this.closest('.cart-item');
            
            try {
                const response = await fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });
                
                const data = await response.json();
                if (data.success) {
                    itemElement.remove();
                    updateCartTotal();
                    
                    // If cart is now empty, show empty message
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        document.querySelector('.bg-white').innerHTML = 
                            '<p class="text-gray-500 p-4">Your cart is empty</p>';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});