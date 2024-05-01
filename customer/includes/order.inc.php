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


    $sqlFindRandomAdmin = "SELECT * FROM admins ORDER BY RAND() LIMIT 1";
    $stmt3 = mysqli_query($conn, $sqlFindRandomAdmin);
    if ($stmt3) {
        $adminRow = mysqli_fetch_assoc($stmt3);
        $adminID = $adminRow["id"];
    }

    $sqlLayanan = "SELECT * FROM layanans WHERE jenis=?";
    $stmt4 =  mysqli_stmt_init($conn);



    if (mysqli_stmt_prepare($stmt4, $sqlLayanan)) {

        mysqli_stmt_bind_param($stmt4, "s", $jenis);
        mysqli_stmt_execute($stmt4);
        $resultLayanan = mysqli_stmt_get_result($stmt4);

        if ($resultLayanan) {

            $layananRow = mysqli_fetch_assoc($resultLayanan);
            $layananID = $layananRow["id"];
        } else {
            echo "Error " . mysqli_error($conn);
        }
    } else {
        header("Location: ../ride.php?error");
    }

    // Debug: Print out the values of variables to check their content
    echo "adminID: " . $adminID . "<br>";
    echo "layananID: " . $layananID . "<br>";

    $sql = "INSERT INTO orders(id, tarif, tanggal, total, asal, tujuan, diskon, payment_method, notes, customers_id, admins_id, layanans_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../order.php");
        exit();
    } else {
        $invoiceID =  generateID();
        $encryptedID = DataEncrypt($invoiceID, $encryptionKey);
        $zero = 0;
        $currdate = date("YmdHis");
        $encryptedPickup = DataEncrypt($pickup, $encryptionKey);
        $encryptedDestination = DataEncrypt($destination,$encryptionKey);
        $driverID = "";


        mysqli_stmt_bind_param($stmt, "ssssssssssss", $encryptedID, $tarif, $currdate, $price, $encryptedPickup, $encryptedDestination, $zero, $payment_method, $notes, $customerID, $adminID, $layananID);
        // Execute the SQL query
        if (mysqli_stmt_execute($stmt)) {
            $keyOrderID = generateIDKey();
            $sqlKey = "INSERT into keyOrders(id,orders_id, encryptionkey) VALUES(?,?,?)";
            //('$keyOrderID','$encryptedID', '$encryptionKey')";

            $stmtSqlKey =  mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmtSqlKey, $sqlKey)) {
                // Query executed successfully
                // Redirect to a success page or perform any additional actions
                mysqli_stmt_bind_param($stmtSqlKey, "sss", $keyOrderID, $encryptedID, $encryptionKey);
                mysqli_stmt_execute($stmtSqlKey);

                $orderSummary = array(
                    "id" => $invoiceID,
                    "encryptedID" => $encryptedID,
                    "tanggal" => $currdate,
                    "total" => $price,
                    "asal" => $pickup,
                    "tujuan" => $destination,
                    "payment_method" => $payment_method,
                    "notes" => $notes,
                    "layanan" => $jenis,
                    "distance" => $distance
                );

                $_SESSION["ordersummary"] = $orderSummary;

                header("Location:../ordersummary.php");

            } else {
                echo "Error " . mysqli_error($conn);
            }
        } else {
            // Query execution failed
            // Print out the error message for debugging
            echo "Error executing query: " . mysqli_stmt_error($stmt);
        }
    }
} 
else {
    header("Location: ../ride.php");
    exit();
}
