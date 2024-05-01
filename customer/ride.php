<?php
session_start();
include "includes/layanan.inc.php";
$userLogged = $_SESSION["userLogged"];

$layanans = $_SESSION["layanans"];

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
            <div>
                <label for="selectLayanan">Layanan:</label>
                <?php if (!empty($layanans)) : ?>
                    <select name="selectLayanan" id="selectLayanan">
                        <?php foreach ($layanans as $layanan) : ?>
                            <option value="<?= $layanan["jenis"] ?>" id="<?= $layanan["tarif"] ?>"><?= $layanan["jenis"] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else : ?>
                    <p>No layanans available</p>
                <?php endif; ?>
            </div>
            <div>
                <label for="">Payment:</label>
                <select name = "selectedPayment" id = "selectedPayment">
                    <option value="Cash" id = "Cash">Cash</option>
                    <option value="E-wallet" id = "E-wallet">E-wallet</option>
                </select>
            </div>
            <div class = "form-group">
                <label for="">Notes:</label>
                <input type="text" id = "notesfill" name = "notesfill" placeholder ="Add notes..">

            </div>
            <label id="labelHarga"></label>
            <button type="submit" name="search-submit" class="btn btn-lg btn-block" style="color: white;background-color: black;">Search</button>
        </div>
        </div>
    </form>
    <div class="container">
        <form id="orderForm" action="includes/order.inc.php" method="POST">
            <input type="hidden" id="pickup" name="pickup">
            <input type="hidden" id="destination" name="destination">
            <input type="hidden" id="distance" name="distance">
            <input type="hidden" id="price" name="price">
            <input type="hidden" id="tarif" name="tarif">
            <input type="hidden" id="jenis" name="jenis">
            <input type="hidden" id="payment_method" name="payment_method">
            <input type="hidden" id="notes" name="notes">
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

                var notes = document.getElementById("notesfill").value;
                console.log(notes);

                var selectedElement = document.getElementById("selectLayanan");
                var selectedOption = selectedElement.options[selectedElement.selectedIndex];
                var selectedOptionID = selectedOption.id;
                var selectedOptionValue = selectedOption.value;


                var selectedPayment =  document.getElementById("selectedPayment");
                var selectedPaymentOption =selectedPayment.options[selectedPayment.selectedIndex];
                var selectedPaymentOptionValue = selectedPaymentOption.value;


                var price = selectedOptionID * Math.round(distance);        

                var labelHarga =document.getElementById("labelHarga");

                labelHarga.textContent = "Total: Rp" + price;









                //update hidden inputs 
                document.getElementById('tarif').value =selectedOptionID;
                document.getElementById('notes').value =notes;
                document.getElementById('pickup').value = pickupLocation;
                document.getElementById('destination').value = destination;
                document.getElementById('distance').value = distance;
                document.getElementById('price').value = price;
                document.getElementById('jenis').value = selectedOptionValue;
                document.getElementById('payment_method').value = selectedPaymentOptionValue;
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