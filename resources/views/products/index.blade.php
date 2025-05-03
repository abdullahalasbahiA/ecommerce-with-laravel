{{-- @extends('layouts.app') --}}
<x-my-layout>
    {{-- @dd($products[0]->image_path) --}}
    <x-slot name='sidebar'><!-- Mobile filter button (visible on small screens) -->
        <button id="filterToggle"
            class="md:hidden fixed bottom-6 right-6 z-30 bg-blue-600 text-white p-3 rounded-full shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </button>

        <!-- Sidebar Filters (hidden on mobile) -->
        <div id="sidebarFilters" style="width:300px; height:100vh; background-color:rgb(238, 238, 238)"
            class="hidden md:block bg-slate-200 p-4 md:p-6 shadow-md md:shadow-none md:mr-6 h-fit md:sticky md:top-4">
            <!-- Close button for mobile -->
            <div class="flex justify-between items-center mb-4 md:hidden">
                <h2 class="text-xl font-bold">Filters</h2>
                <button id="closeFilters" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Filter Sections -->
            <div class="space-y-6">
                <!-- Price Range Filter -->
                <div>
                    <h3 class="font-semibold mb-3">Price Range</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="price1" class="rounded text-blue-600">
                            <label for="price1" class="ml-2 text-gray-700">$0 - $50</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="price2" class="rounded text-blue-600">
                            <label for="price2" class="ml-2 text-gray-700">$50 - $100</label>
                        </div>
                        <!-- Add more price ranges as needed -->
                    </div>
                </div>

                <!-- Categories Filter -->
                <div>
                    <h3 class="font-semibold mb-3">Categories</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="cat1" class="rounded text-blue-600">
                            <label for="cat1" class="ml-2 text-gray-700">Electronics</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="cat2" class="rounded text-blue-600">
                            <label for="cat2" class="ml-2 text-gray-700">Clothing</label>
                        </div>
                        <!-- Add more categories as needed -->
                    </div>
                </div>

                <!-- Rating Filter -->
                <div>
                    <h3 class="font-semibold mb-3">Rating</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="rating5" class="rounded text-blue-600">
                            <label for="rating5" class="ml-2 flex items-center">
                                <div class="flex text-yellow-400">
                                    <!-- 5 stars -->
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <!-- Repeat 4 more times -->
                                </div>
                            </label>
                        </div>
                        <!-- Add more rating options as needed -->
                    </div>
                </div>

                <button class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                    Apply Filters
                </button>
            </div>
        </div>
    </x-slot>

    @foreach ($products as $product)
        <x-product-card :product="$product" />
    @endforeach
</x-my-layout>
