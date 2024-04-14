<?php
session_start();
include "dbconn.inc.php";
include "cryptographic.inc.php";

function generateID()
{
    $currdate = date("YmdHis");
    $id = "INVGGRB" . $currdate;
    return $id;
}
function generateIDKey()
{
    $currdate = date("YmdHis");
    $id = "ORDKEY" . $currdate;
    return $id;
}

$customerID = $_SESSION["id"];

if (isset($_POST["order-submit"])) {

    $pickup = $_POST["pickup"];
    $destination = $_POST["destination"];
    $distance = $_POST["distance"];
    $price = $_POST["price"];
    $jenis = $_POST["jenis"];
    $tarif = $_POST["tarif"];
    $payment_method = $_POST["payment_method"];
    $notes = $_POST["notes"];

    // Debug: Print out the values of variables to check their content
    echo "pickup: " . $pickup . "<br>";
    echo "destination: " . $destination . "<br>";
    echo "distance: " . $distance . "<br>";
    echo "price: " . $price . "<br>";
    echo "jenis: " . $jenis . "<br>";
    echo "tarif: " . $tarif . "<br>";
    echo "payment_method: " . $payment_method . "<br>";
    echo "notes: " . $notes . "<br>";

    $driverID;
    $adminID;
    $layananID;
    $encryptionKey =  GenerateKey();


    $sqlFindRandomDriver = "SELECT * FROM drivers ORDER BY RAND() LIMIT 1";
    $stmt2 = mysqli_query($conn, $sqlFindRandomDriver);
    if ($stmt2) {
        $driverRow = mysqli_fetch_assoc($stmt2);
        $driverID = $driverRow["id"];
    }

    $sqlFindRandomAdmin = "SELECT * FROM admins ORDER BY RAND() LIMIT 1";
    $stmt3 = mysqli_query($conn, $sqlFindRandomAdmin);
    if ($stmt3) {
        $adminRow = mysqli_fetch_assoc($stmt3);
        $adminID = $adminRow["id"];
    }

    $sqlLayanan = "SELECT * FROM layanans WHERE jenis='$jenis'";
    $stmt4 =  mysqli_query($conn, $sqlLayanan);
    if ($stmt4) {
        $layananRow = mysqli_fetch_assoc($stmt4);
        $layananID = $layananRow["id"];
    }

    // Debug: Print out the values of variables to check their content
    echo "driverID: " . $driverID . "<br>";
    echo "adminID: " . $adminID . "<br>";
    echo "layananID: " . $layananID . "<br>";

    $sql = "INSERT INTO orders(id, tarif, tanggal, total, asal, tujuan, diskon, payment_method, notes, customers_id, drivers_id, admins_id, layanans_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../order.php");
        exit();
    } else {
        $invoiceID =  generateID();
        $encryptedID = DataEncrypt($invoiceID, $encryptionKey);
        $zero = 0;
        $currdate = date("YmdHis");
        mysqli_stmt_bind_param($stmt, "sssssssssssss", $encryptedID, $tarif, $currdate, $price, $pickup, $destination, $zero, $payment_method, $notes, $customerID, $driverID, $adminID, $layananID);
        // Execute the SQL query
        if (mysqli_stmt_execute($stmt)) {
            $keyOrderID = generateIDKey();
            $sqlKey = "INSERT into keyOrders(id,orders_id, encryptionkey) VALUES('$keyOrderID','$encryptedID', '$encryptionKey')";

            $stmtSqlKey =  mysqli_query($conn, $sqlKey);

            if ($stmtSqlKey) {
                // Query executed successfully
                // Redirect to a success page or perform any additional actions
                header("Location: ../index.php");
                exit();
            }
            else{
                echo "Error " . mysqli_error($conn);
            }
        } else {
            // Query execution failed
            // Print out the error message for debugging
            echo "Error executing query: " . mysqli_stmt_error($stmt);
        }
    }
} else {
    header("Location: ../order.php");
    exit();
}
