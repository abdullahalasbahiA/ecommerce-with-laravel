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
                {{-- Brand Filter --}}

                {{-- Price Filter --}}
                {{-- Connectivity Filter --}}
                {{-- Wearing Style Filter --}}



                <x-search-filters :features="$features" />

            </div>
        </div>


    </x-slot>

    {{-- @foreach ($products as $product)
        <x-product-card :product="$product" />
    @endforeach --}}
    <h2>Results:</h2>
    <ul id="results" style="display: flex; flex-wrap:wrap"></ul>

    <div id="pagination" class="mt-4 flex gap-2"></div>

</x-my-layout>
