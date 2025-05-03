<x-my-layout>
    <div class="container mx-auto px-4 py-8">

        <div class="lg:flex lg:space-x-8">
            <!-- Product Images -->
            <div class="lg:w-1/2">
                <!-- Main Image -->
                <div class="bg-white rounded-lg overflow-hidden mb-4">
                    <img src="{{ asset('images/item1.png') }}" style="height: 500px" alt="Product"
                        class="w-full object-contain">
                </div>

                <!-- Thumbnails -->
                <div class="grid grid-cols-5 gap-2">
                    <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded">
                        <img src="{{ asset('images/item1.png') }}" alt="Thumbnail 1" class="w-full h-20 object-contain">
                    </div>
                    <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded">
                        <img src="{{ asset('images/item2.png') }}" alt="Thumbnail 1" class="w-full h-20 object-contain">
                    </div>
                    <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded">
                        <img src="{{ asset('images/item3.jpg') }}" alt="Thumbnail 2" class="w-full h-20 object-contain">
                    </div>
                    <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded">
                        <img src="{{ asset('images/item4.jpg') }}" alt="Thumbnail 3" class="w-full h-20 object-contain">
                    </div>
                    <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded">
                        <img src="{{ asset('images/item5.webp') }}" alt="Thumbnail 4"
                            class="w-full h-20 object-contain">
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="lg:w-1/2 mt-6 lg:mt-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Noble Audio Sultan In-Ear Headphones</h1>

                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <!-- Repeat for 4 more stars -->
                    </div>
                    <span class="text-gray-600 ml-2">4.8 (142 reviews)</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-3xl font-bold text-gray-900">$3,999</span>
                    <span class="text-sm text-gray-500 line-through ml-2">$4,299</span>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold ml-2 px-2.5 py-0.5 rounded">7%
                        OFF</span>
                </div>

                <!-- Color Options -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Color</h3>
                    <div class="flex space-x-2">
                        <button
                            class="w-8 h-8 rounded-full bg-black border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></button>
                        <button
                            class="w-8 h-8 rounded-full bg-gray-600 border-2 border-transparent hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></button>
                        <button
                            class="w-8 h-8 rounded-full bg-red-600 border-2 border-transparent hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></button>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Quantity</h3>
                    <div class="flex items-center">
                        <button class="bg-gray-200 px-3 py-1 rounded-l focus:outline-none">-</button>
                        <input type="text" value="1"
                            class="w-12 text-center border-t border-b border-gray-200 py-1">
                        <button class="bg-gray-200 px-3 py-1 rounded-r focus:outline-none">+</button>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4 mb-8">
                    <button
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition duration-300">
                        Add to Cart
                    </button>
                    <button
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-lg font-medium transition duration-300">
                        Buy Now
                    </button>
                </div>

                <!-- Product Details -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-600 mb-6">The Noble Audio Sultan represents the pinnacle of in-ear monitor
                        technology, featuring an innovative hybrid driver array that delivers unparalleled sound quality
                        with precision-tuned acoustics.</p>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Driver Type</h4>
                            <p class="text-sm text-gray-600">8 Balanced Armature + 1 Dynamic</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Frequency Response</h4>
                            <p class="text-sm text-gray-600">5Hz - 22kHz</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Impedance</h4>
                            <p class="text-sm text-gray-600">32 ohms</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Sensitivity</h4>
                            <p class="text-sm text-gray-600">108dB @1mW</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16 border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>

            <div class="space-y-8">
                <!-- Single Review -->
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center mb-2">
                        <div class="flex">
                            <!-- Stars -->
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Repeat for 4 more stars -->
                        </div>
                        <h3 class="ml-2 text-lg font-medium text-gray-900">Perfect sound quality</h3>
                    </div>
                    <p class="text-gray-600 mb-2">By John D. on January 15, 2023</p>
                    <p class="text-gray-700">These are by far the best IEMs I've ever used. The soundstage is incredible
                        for in-ear monitors, and the bass response is perfect - deep and powerful without being
                        overwhelming.</p>
                </div>

                <!-- Add more reviews as needed -->
            </div>
        </div>
    </div>

    <script>
        // Simple image gallery functionality
        document.querySelectorAll('.cursor-pointer img').forEach(thumb => {
            thumb.addEventListener('click', function() {
                const mainImg = document.querySelector('.bg-white img');
                mainImg.src = this.src.replace('-thumb', '-large');
            });
        });

        // Quantity selector
        const quantityInput = document.querySelector('input[type="text"]');
        document.querySelectorAll('.flex.items-center button').forEach(btn => {
            btn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (this.textContent === '+') {
                    quantityInput.value = value + 1;
                } else if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
        });
    </script>
</x-my-layout>
