<x-my-layout>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Your Shopping Cart</h1>

        @if (count($cart))
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @foreach ($products as $product)
                    @php
                        $quantity = $cart[$product->id];
                        $itemTotal = $product->price * $quantity;
                    @endphp
                    <div class="p-4 border-b flex justify-between items-center cart-item" data-product-id="{{ $product->id }}">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <h3 class="font-medium">{{ $product->name }}</h3>
                                <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="mr-4 text-right">
                                <div class="item-total font-medium">${{ number_format($itemTotal, 2) }}</div>
                                <div class="text-sm text-gray-500">${{ number_format($product->price, 2) }} × <span class="quantity-display">{{ $quantity }}</span></div>
                            </div>
                            
                            <input type="number" value="{{ $quantity }}" min="1"
                                class="quantity-input w-16 text-center border rounded py-1"
                                data-product-id="{{ $product->id }}">

                            <button class="remove-item ml-4 text-red-500 hover:text-red-700"
                                data-product-id="{{ $product->id }}">
                                Remove
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <div class="p-4 bg-gray-50 flex justify-between items-center">
                    <span class="font-bold">Total: $<span id="cart-total">{{ number_format(array_reduce($products->all(), function($carry, $product) use ($cart) {
                        return $carry + ($product->price * $cart[$product->id]);
                    }, 0), 2) }}</span></span>
                    <a href="{{ route('cart.index') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        @else
            <p class="text-gray-500">Your cart is empty</p>
        @endif
    </div>

</x-my-layout>
