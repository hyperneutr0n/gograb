<?php
session_start();
$userLogged = $_SESSION["userLogged"];

if ($userLogged) {
    require "header.php";
} else {
    $_SESSION["userLogged"] = $userLogged;
    header("Location: login.php");
}
?>

<main>
    <!-- Map container -->
    <div id="map" style="width:100%;height:400px;"></div>
    <!-- Form section -->
    <form id="rideForm" method="POST" action="">
        <div class="container mt-5">
            <h2>Where to?</h2>
            <div class="form-group">
                <label for="pickup_location">Pick up location</label>
                <input type="text" class="form-control" id="pickup_location" name="pickup_location" placeholder="Enter pick up location">
            </div>
            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" class="form-control" id="destination_location" name="destination" placeholder="Enter destination">
            </div>
            <button type="submit" name="search-submit" class="btn btn-lg btn-block" style="color: white;background-color: black;">Search</button>
        </div>
        </div>
    </form>
    <div class="container">
        <form id="orderForm" action="includes/order.inc.php" method="POST">
            <input type="hidden" id="pickup" name="pickup">
            <input type="hidden" id="destination" name="destination">
            <input type="hidden" id="distance" name="distance">
            <button type="submit" name="order-submit" class="btn btn-lg btn-block mt-2 mb-4" style="color: white;background-color: black;">Order</button>
        </form>
    </div>
</main>


<script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoieWFuc3UyOCIsImEiOiJjbHU5dW1iNWgwZW94MmxtbTVmc2l5b2RjIn0.v4CpG-xzt0yhJucczgIA5w';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-74.5, 40], // Default center position
        zoom: 9
    });

    // Declare variables for markers
    var pickupMarker = new mapboxgl.Marker();
    var destinationMarker = new mapboxgl.Marker();

    // Event listener for form submission
    document.getElementById('rideForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get pickup location and destination from inputs
        var pickupLocation = document.getElementById('pickup_location').value;
        var destination = document.getElementById('destination_location').value;

        // Use Mapbox Geocoding API to get coordinates
        geocode(pickupLocation, function(pickupCoordinates) {
            geocode(destination, function(destinationCoordinates) {
                // Update marker positions
                updateMarkers(pickupCoordinates, destinationCoordinates);

                // Update map's view to fit both markers
                fitBounds(pickupCoordinates, destinationCoordinates);

                // Calculate distance between pickup and destination
                var distance = calculateDistance(pickupCoordinates, destinationCoordinates) / 1000;
                console.log('Distance: ' + distance + ' km');
                document.getElementById('pickup').value = pickupLocation;
                document.getElementById('destination').value = destination;
                document.getElementById('distance').value = distance;
            });
        });
    });


    // Function to geocode a location using Mapbox Geocoding API
    function geocode(location, callback) {
        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(location)}.json?access_token=${mapboxgl.accessToken}`)
            .then(response => response.json())
            .then(data => {
                var coordinates = data.features[0].geometry.coordinates; // [longitude, latitude]
                callback(coordinates);
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to calculate distance between two coordinates (in meters)
    function calculateDistance(coord1, coord2) {
        return turf.distance(coord1, coord2) * 1000; // Convert to meters
    }

    // Function to update marker positions
    function updateMarkers(pickupCoordinates, destinationCoordinates) {
        pickupMarker.setLngLat(pickupCoordinates).addTo(map);
        destinationMarker.setLngLat(destinationCoordinates).addTo(map);
    }

    // Function to fit map's view to show both markers
    function fitBounds(pickupCoordinates, destinationCoordinates) {
        var bounds = new mapboxgl.LngLatBounds();
        bounds.extend(pickupCoordinates);
        bounds.extend(destinationCoordinates);
        map.fitBounds(bounds, {
            padding: 100
        });
    }
</script>

<?php require "footer.php"; ?>