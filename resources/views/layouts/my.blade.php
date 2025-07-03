<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A simple e-commerce application built with Laravel.">
    <meta name="keywords" content="Laravel, e-commerce, shopping cart, products">
    <meta name="author" content="Abdullah Alasbahi">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}


    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">     --}}

    <style>
        /* Custom styling for the add to cart button animation */
        .add-to-cart-btn {
            position: relative;
            overflow: hidden;
        }

        .add-to-cart-btn:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .add-to-cart-btn:focus:after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 1;
            }

            20% {
                transform: scale(25, 25);
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="">
        {{-- ========================================================= --}}
        {{-- ==================== Start Of The Nav =================== --}}
        {{-- ========================================================= --}}
        <nav class="bg-white shadow-lg">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex justify-between">
                    <div class="flex space-x-7">
                        <!-- Website Logo -->
                        <div>
                            <a href="/" class="flex items-center py-4 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184
                                         1.707.707 1.707H17m0 0a2 2 0
                                         100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="font-semibold text-gray-500 text-lg">ShopCart</span>
                            </a>
                        </div>
                        <!-- Primary Navbar items -->
                        <div class="hidden md:flex items-center space-x-1">
                            <a href="/"
                                class="py-4 px-2 text-blue-500 border-b-4 border-blue-500 font-semibold ">Home</a>
                            <a href="/products/create"
                                class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Add
                                Product</a><a href="/orders"
                                class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">orders</a>
                            <a href="#"
                                class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Categories</a>
                            <a href="#"
                                class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">About</a>
                            <a href="#"
                                class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Contact</a>
                        </div>
                    </div>
                    <!-- Secondary Navbar items -->
                    <div class="hidden md:flex items-center space-x-3 ">
                        @auth
                            <span>
                                welcome, {{ auth()->user()->name }}
                            </span>
                            <a href="{{ route('logout') }}"
                                class="py-2 px-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="/login"
                                class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-blue-500 hover:text-white transition duration-300">Log
                                In</a>
                            <a href="/register"
                                class="py-2 px-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-400 transition duration-300">Sign
                                Up</a>
                        @endauth
                        <a href="{{ route('cart.index') }}" class="relative">
                            🛒
                            <span
                                class="cart-count 
                                absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                <span id="cart-count">0</span>
                            </span>
                        </a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button class="outline-none mobile-menu-button">
                            <svg class=" w-6 h-6 text-gray-500 hover:text-blue-500 " x-show="!showMenu" fill="none"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- mobile menu -->
            <div class="hidden mobile-menu">
                <ul class="">
                    <li class="active"><a href="/"
                            class="block text-sm px-2 py-4 text-white bg-blue-500 font-semibold">Home</a></li>
                    <li><a href="/product" class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Add
                            Product</a></li>
                    <li><a href="#"
                            class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Categories</a>
                    </li>
                    <li><a href="#"
                            class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">About</a></li>
                    <li><a href="#"
                            class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Contact Us</a>
                    </li>
                    <li class="border-t border-gray-200"><a href="/login"
                            class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Log In</a></li>
                    <li><a href="/register"
                            class="block text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">Sign Up</a></li>
                    <li class="border-t border-gray-200">
                        <a href="#"
                            class="flex items-center text-sm px-2 py-4 hover:bg-blue-500 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Cart (0)
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <script>
            // Mobile menu toggle
            const btn = document.querySelector("button.mobile-menu-button");
            const menu = document.querySelector(".mobile-menu");

            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
            // hide the menu when clicking away
            document.addEventListener("click", (e) => {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add("hidden");
                }
            });
            // hide the menu when screen gets larger than 768px
            window.addEventListener("resize", () => {
                if (window.innerWidth > 768) {
                    menu.classList.add("hidden");
                }
            });

            // ===========================================================================
            // ===========================================================================
            // ===========================================================================
            // ============================== Sidebar CODE  ==============================
            // ===========================================================================
            // ===========================================================================
            // ===========================================================================

            document.addEventListener('DOMContentLoaded', function() {
                const filterToggle = document.getElementById('filterToggle');
                const closeFilters = document.getElementById('closeFilters');
                const sidebarFilters = document.getElementById('sidebarFilters');

                // Toggle sidebar on mobile
                filterToggle.addEventListener('click', function() {
                    sidebarFilters.classList.remove('hidden');
                    sidebarFilters.classList.add('fixed', 'inset-0', 'z-20', 'bg-white', 'p-4',
                        'overflow-y-auto');
                });

                // Close sidebar
                closeFilters.addEventListener('click', function() {
                    sidebarFilters.classList.add('hidden');
                    sidebarFilters.classList.remove('fixed', 'inset-0', 'z-20', 'bg-white', 'p-4',
                        'overflow-y-auto');
                });
            });
        </script>
        {{-- ========================================================= --}}
        {{-- ===================== End Of The Nav ==================== --}}
        {{-- ========================================================= --}}
        <div class="flex flex-col md:flex-row">
            {{ $sidebar ?? '' }}
            {{-- add classes to make the product cards flex --}}
            <div style="max-width:83%; margin:auto; padding-top: 10px; " class="mb-3 flex-wrap justify-center">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="{{ asset('js/ajax_search.js') }}" defer></script>
    <script src="{{ asset('js/cart.js') }}" defer></script>
</body>

</html>
