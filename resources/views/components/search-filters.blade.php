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



    <button type="submit">Search</button>
    <button type="button" onclick="clearFilters()">Clear</button>
</form>
