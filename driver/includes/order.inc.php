<?php
session_start();
include "dbconn.inc.php";
include "cryptographic.inc.php";

$order = array();
$customerName = "";
$orderEncryptionKey = "";

if (isset($_SESSION["driverLogged"]) && $_SESSION["driverLogged"] == true) {
    //query tabel orders
    $layanan = $_SESSION["kendaraan"];
    $driver = $_SESSION["driverName"];
    //echo $driver;
    if ($layanan == "Car") {
        $id_layanan = 2;
    } else {
        $id_layanan = 1;
    }




    $sql4 = "SELECT*FROM orders where layanans_id = $id_layanan AND order_finished = '0'";
    $stmt4 = mysqli_query($conn, $sql4);

    if ($stmt4) {

        while ($innerrow = mysqli_fetch_assoc($stmt4)) {

            $sql = "SELECT * FROM orders WHERE layanans_id = '$id_layanan'";
            $stmt = mysqli_query($conn, $sql);

            if ($stmt) {
                $row = mysqli_fetch_assoc($stmt);
                $customerID = $row["customers_id"];
                $invoiceID = $row["id"];
            } else {
                echo "Error fetching customer customer: " . mysqli_error($conn);
            }

            $sql2 = "SELECT*FROM customers WHERE id = '$customerID'";
            $stmt2 = mysqli_query($conn, $sql2);
            if ($stmt2) {
                $rowCustomer = mysqli_fetch_assoc($stmt2);
                $customerName = $rowCustomer["nama"];
                //echo $customerName;
            } else {
                echo "Error fetching database: " . mysqli_error($conn);
            }
            $sql3 = "SELECT encryptionKey FROM keyOrders WHERE orders_id = '{$innerrow['id']}'";
            $stmt3 = mysqli_query($conn, $sql3);
            if ($stmt3) {
                $rowKey = mysqli_fetch_assoc($stmt3);
                $orderEncryptionKey = $rowKey["encryptionKey"];

                //echo $orderEncryptionKey;
            } else {
                echo "Error fetching order encryption key: " . mysqli_error($conn);
            }

            // Dekripsi data pesanan



            // echo $decryptedID;
            // echo $decryptedAsal;
            // echo $decryptedTujuan;


            // Simpan data pesanan ke dalam array
            $order[] = array(
                "key" => $orderEncryptionKey,
                "id" => $innerrow["id"],
                "tarif" => $innerrow['tarif'],
                "tanggal" => $innerrow['tanggal'],
                "total" => $innerrow['total'],
                "asal" => $innerrow["asal"],
                "tujuan" => $innerrow["tujuan"],
                "diskon" => $innerrow['diskon'],
                "payment_method" => $innerrow['payment_method'],
                "notes" => $innerrow['notes'],
                "customers_id" => $innerrow['customers_id'],
                "customer_name" => $customerName,
                "drivers_id" => $innerrow['drivers_id'],
                "admins_id" => $innerrow['admins_id'],
                "layanans_id" => $innerrow['layanans_id']
            );
        }


        foreach ($order as $orders) {
            echo "EncryptionKey: " . $orderEncryptionKey;
            echo "INVOICE: " . $orders["id"];
            echo "Asal: " . $orders["asal"];
            echo "<br>";
        }
        $_SESSION["order"] = $order;

        header("Location: ../order.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
