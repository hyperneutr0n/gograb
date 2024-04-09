<?php
session_start();
if (isset($_SESSION["userLogged"]) && $_SESSION["userLogged"]== true) {
    require "header.php";
} else {
    $userLogged = false;
    header("Location: login.php");
}

?>

<main>
    <!-- Map container -->
    <div id="map" style="width:100%;height:400px;"></div>
    <!-- Form section -->
    <form action="" method="POST">

        <div class="container mt-5">
            <h2>Where to?</h2>
            <div class="form-group">
                <label for="pickup_location">Pick up location</label>
                <input type="text" class="form-control" id="pickup_location" placeholder="Enter pick up location">
            </div>
            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" class="form-control" id="destination" placeholder="Enter destination">
            </div>
            <button type="button" class="btn btn-lg btn-block">Request Ride</button>
            <div class="row mt-4"></div>
        </div>
    </form>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <script>
        // Initialize Mapbox map
        mapboxgl.accessToken = 'pk.eyJ1IjoieWFuc3UyOCIsImEiOiJjbHU5dW1iNWgwZW94MmxtbTVmc2l5b2RjIn0.v4CpG-xzt0yhJucczgIA5w';
        var map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [-74.5, 40], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });
    </script>
</main>

<?php

require "footer.php";

?>
