<?php

require "dbconn.inc.php";

session_start();
if(isset($_POST["submit"])){
    $id = $_POST["id"];
    $driverID = $_SESSION["driverId"];

    echo "$driverID";

    $sql = "UPDATE orders SET drivers_id ='$driverID', order_finished = '1' 
    WHERE id = '$id'";

    $stmt = mysqli_query($conn,$sql);

    if($stmt){
        header("Location: ../ordarsummary.php");
    }
    else{
        header("Location: ../order.php?failed");
    }










}
else{
    header("Location: ../order.php");
}
