<x-my-layout>
    <div style="width: 1000px; margin:20px 0 60px">
        <div width="700px" style="width: 100%" class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
            </div>

            <!-- Form -->
            <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                    <input class="w-full" type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price Field -->
                <div class="mb-6">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input class="w-full" type="number" id="price" name="price" step="0.01" min="0"
                        value="{{ old('price') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Field -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category" name="category"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Select a category</option>
                        <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics
                        </option>
                        <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>Home</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                    <div class="mt-1 flex items-center">
                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 49.641 49.64"
                                xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M44.118,11.852c-0.008-0.014-0.022-0.021-0.03-0.034c-0.031-0.046-0.067-0.085-0.109-0.122 c-0.014-0.01-0.023-0.021-0.036-0.03c-0.067-0.05-0.141-0.091-0.225-0.11L23.068,6.721c-0.108-0.024-0.226-0.019-0.336,0.015 L8.002,11.57c-0.042,0.015-0.075,0.043-0.112,0.065c-0.024,0.014-0.053,0.017-0.074,0.033c-0.006,0.005-0.009,0.014-0.015,0.019 c-0.006,0.006-0.016,0.007-0.022,0.014l-7.573,6.81c-0.222,0.202-0.271,0.533-0.116,0.788c0.112,0.187,0.317,0.303,0.535,0.303 c0.076,0,0.149-0.014,0.218-0.039l6.73-2.508v20.163c0,0.286,0.193,0.535,0.471,0.604l19.957,5.092 c0.048,0.014,0.1,0.021,0.158,0.021c0.069,0,0.137-0.011,0.202-0.032l14.935-5.094c0.254-0.085,0.424-0.323,0.424-0.591V24.155 l5.5-1.904c0.177-0.062,0.315-0.196,0.381-0.371s0.051-0.367-0.043-0.53L44.118,11.852z M7.571,15.718l-4.086,1.524l4.086-3.677 V15.718z M27.532,41.505l-18.71-4.773V12.978l18.71,5.012V41.505z M28.136,16.856l-17.749-4.754l12.568-4.124l18.377,4.302 L28.136,16.856z M42.468,36.77l-13.686,4.666V18.815l5.607,8.089c0.118,0.168,0.31,0.27,0.515,0.27 c0.065,0,0.134-0.012,0.205-0.034l7.359-2.55L42.468,36.77L42.468,36.77z M35.147,25.8l-5.619-8.104l13.763-4.772l4.805,8.392 L35.147,25.8z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <label for="image" class="ml-5 cursor-pointer">
                            <span
                                class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Choose file
                            </span>
                            <input class="w-full hidden" id="image" name="image" type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('products.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.querySelector('.inline-block.h-12.w-12');
                    preview.innerHTML = `<img src="${event.target.result}" class="h-full w-full object-cover">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-my-layout>
