<form onsubmit="event.preventDefault(); searchCars(1);">
    <input type="number" id="price_min" placeholder="Min Price">
    <input type="number" id="price_max" placeholder="Max Price">

    <select id="make">
        <option value="">Any Make</option>
        <option value="Toyota">Toyota</option>
        <option value="Honda">Honda</option>
        <option value="Ford">Ford</option>
        <option value="BMW">BMW</option>
        <option value="Audi">Audi</option>
        <option value="Mercedes">Mercedes</option>
        <option value="Chevrolet">Chevrolet</option>
        <option value="Tesla">Tesla</option>
    </select>

    <input type="number" id="year" placeholder="Year (optional)">

    <select id="fuel_type">
        <option value="">Any Fuel</option>
        <option value="Gasoline">Gasoline</option>
        <option value="Diesel">Diesel</option>
        <option value="Electric">Electric</option>
        <option value="Hybrid">Hybrid</option>
    </select>

    <button type="submit">Search</button>
    <button type="button" onclick="clearFilters()">Clear</button>
</form>