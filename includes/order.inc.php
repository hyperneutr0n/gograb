<?php

if(isset($_POST["order-submit"])){

    $pickup =  $_POST["pickup"];
    $destination =  $_POST["destination"];
    $distance = $_POST["distance"];
    $price = $_POST["price"];
}else{
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Order Details</h1>
    <p>Pickup Location: <?php echo $pickup; ?></p>
    <p>Destination: <?php echo $destination; ?></p>
    <p>Distance: <?php echo $distance; ?> km</p>
    <p>Price: <?php echo $price; ?> km</p>
</body>
</html>