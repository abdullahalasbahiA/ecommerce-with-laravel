async function searchCars(page = 1) {
    const formParams = new URLSearchParams();
    const priceMin = document.getElementById("price_min").value;
    const priceMax = document.getElementById("price_max").value;
    const make = document.getElementById("make").value;
    const year = document.getElementById("year").value;
    const fuelType = document.getElementById("fuel_type").value;

    if (priceMin) formParams.append("price_min", priceMin);
    if (priceMax) formParams.append("price_max", priceMax);
    if (make) formParams.append("make", make);
    if (year) formParams.append("year", year);
    if (fuelType) formParams.append("fuel_type", fuelType);

    if (!isNaN(page) && typeof page === "number") { // if page var is a number
        formParams.append("page", page); // add the page number
    }

    window.history.pushState(
        {},
        "",
        "/productsSearch?" + formParams.toString()
    ); // Update URL with query params

    const res = await fetch("/api/search?" + formParams.toString());
    const result = await res.json();

    const results = document.getElementById("results");
    results.innerHTML = "";

    result.data.forEach((product) => {
        results.innerHTML += `
        <div style="width:270px" class="m-2 bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Product Image -->
            <div class="relative pb-[78%] overflow-hidden">
                <img 
                    src="/storage/${product.image_url}"
                    alt="${product.name}"
                    class="absolute h-full w-full object-cover hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                >
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
                <!-- Product Name -->
                <h3 class="text-lg font-semibold text-gray-800 mb-1 truncate">
                    ${product.name}
                </h3>
                
                <!-- Star Ratings -->
                <div class="flex items-center mb-2">
                    <div class="flex">
                        <!-- Filled stars -->
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <!-- Empty star -->
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-500 ml-1">(24)</span>
                </div>
                
                <!-- Price -->
                <div class="flex items-center justify-between mt-3">
                    <span class="text-lg font-bold text-gray-900">$${
                        product.price
                    }</span>
                    
                    <!-- Add to Cart Button -->
                    <button class="add-to-cart" data-product-id="${product.id}">
                        Add to Cart
                    </button>
                    <a href="/products/${product.id}/edit" 
                        class="text-purple-600 hover:text-purple-900 mr-3">
                        Edit
                     </a>
                    <form action="/products/${
                        product.id
                    }" method="POST" class="delete-form">
                        <input type="hidden" name="_token" value="${
                            document.querySelector('meta[name="csrf-token"]')
                                .content
                        }">
                        <input type="hidden" name="_method" value="DELETE">
                        <button 
                            type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>`;
    });

    renderPagination(result.current_page, result.last_page);
}

function renderPagination(currentPage, lastPage) {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    // "First" button
    if (currentPage > 3) {
        const firstButton = document.createElement("button");
        firstButton.innerText = "First";
        firstButton.className = "p-2 border rounded hover:bg-gray-200";
        firstButton.addEventListener("click", () => {
            searchCars(1);
        });
        pagination.appendChild(firstButton);
    }

    // Show a window of pages around the current page
    const startPage = Math.max(currentPage - 2, 1);
    const endPage = Math.min(currentPage + 2, lastPage);

    for (let page = startPage; page <= endPage; page++) {
        const button = document.createElement("button");
        button.innerText = page;
        button.className = "p-2 border rounded hover:bg-gray-200";

        if (page === currentPage) {
            button.classList.add("bg-gray-400"); // Highlight current page
        }

        button.addEventListener("click", () => {
            searchCars(page);
        });

        pagination.appendChild(button);
    }

    // "Last" button
    if (currentPage < lastPage - 2) {
        const lastButton = document.createElement("button");
        lastButton.innerText = "Last";
        lastButton.className = "p-2 border rounded hover:bg-gray-200";
        lastButton.addEventListener("click", () => {
            searchCars(lastPage);
        });
        pagination.appendChild(lastButton);
    }
}

function fillFormFromUrl() {
    const params = new URLSearchParams(window.location.search);

    if (params.has("price_min")) {
        document.getElementById("price_min").value = params.get("price_min");
    }
    if (params.has("price_max")) {
        document.getElementById("price_max").value = params.get("price_max");
    }
    if (params.has("make")) {
        document.getElementById("make").value = params.get("make");
    }
    if (params.has("year")) {
        document.getElementById("year").value = params.get("year");
    }
    if (params.has("fuel_type")) {
        document.getElementById("fuel_type").value = params.get("fuel_type");
    }

    return params.has("page") ? parseInt(params.get("page")) : 1;
}

function clearFilters() {
    // Reset all form inputs
    document.getElementById("price_min").value = "";
    document.getElementById("price_max").value = "";
    document.getElementById("make").value = "";
    document.getElementById("year").value = "";
    document.getElementById("fuel_type").value = "";

    // Clear URL parameters
    window.history.pushState({}, "", "/productsSearch");

    // Fetch all cars (unfiltered)
    searchCars();
}

window.addEventListener("DOMContentLoaded", () => {
    if (window.location.search) {
        const page = fillFormFromUrl(); // Fill the form inputs from URL & get the page number
        searchCars(page); // Run search on page load (with the current filters) AND the page
    }
    // when the document load give me all items
    searchCars(new Event("submit"));
});
