@props(['features'])
<form onsubmit="event.preventDefault(); searchCars(1);">
    <input type="number" id="price_min" placeholder="Min Price">
    <input type="number" id="price_max" placeholder="Max Price">

    <div class="col-md-6">
        <h5>Features</h5>
        @foreach ($features as $feature)
            <div class="form-check">
                <input type="checkbox" name="features[]" value="{{ $feature->id }}">
                <label>{{ $feature->name }}</label>
            </div>
        @endforeach
    </div>



    <button class="w-full mb-1 mt-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition" 
    type="submit">Search</button>
    <button class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition" type="button" onclick="clearFilters()">Clear</button>
</form>
