<?php
session_start();
include "dbconn.inc.php";
include "cryptographic.inc.php";

$order = array();

if (isset($_SESSION["driverLogged"]) && $_SESSION["driverLogged"] == true) {
    //query tabel orders
    $layanan = $_SESSION["jenis_kendaraan"];
    if ($layanan == "Car") {
        $id_layanan = 2;
    } else {
        $id_layanan = 1;
    }
    $sql = "SELECT * FROM orders WHERE drivers_id = '' AND layanan_id = $id_layanan";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
        $row = mysqli_fetch_assoc($stmt);
        $customerID = $row["customers_id"];

        // Ambil kunci enkripsi customer dari tabel keycustomer
        $sql2 = "SELECT*FROM customers WHERE id = '$customerID'";
        $stmt2 = mysqli_query($conn, $sql2);
        if ($stmt2) {
            $rowCustomer = mysqli_fetch_assoc($stmt2);
            $customerName = $rowCustomer["nama"];

            // Ambil kunci enkripsi order dari tabel keyOrder
            $sql3 = "SELECT encryptionKey FROM keyOrders WHERE orders_id = '{$row['id']}'";
            $stmt3 = mysqli_query($conn, $sql3);
            if ($stmt3) {
                $orderEncryptionKey = mysqli_fetch_assoc($stmt3)['encryptionKey'];

                while ($row = mysqli_fetch_assoc($stmt)) {
                    // Dekripsi data pesanan
                    $decryptedID = DataDecrypt($row["id"], $orderEncryptionKey);
                    $decryptedAsal = DataDecrypt($row["asal"], $orderEncryptionKey);
                    $decryptedTujuan = DataDecrypt($row["tujuan"], $orderEncryptionKey);

                    // Simpan data pesanan ke dalam array
                    $order[] = array(
                        "id" => $decryptedID,
                        "tarif" => $row['tarif'],
                        "tanggal" => $row['tanggal'],
                        "total" => $row['total'],
                        "asal" => $decryptedAsal,
                        "tujuan" => $decryptedTujuan,
                        "diskon" => $row['diskon'],
                        "payment_method" => $row['payment_method'],
                        "notes" => $row['notes'],
                        "customers_id" => $row['customer_id'],
                        "drivers_id" => $row['customer_id'],
                        "admins_id" => $row['admins_id'],
                        "layanans_id" => $row['layanans_id']
                    );
                }
                $_SESSION["order"] = $order;
                header("Location: ../order.php");
                exit();
            } else {
                echo "Error fetching order encryption key: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching customer customer: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching database: " . mysqli_error($conn);
    }
} else {
    header("Location: ../index.php");
    exit();
}
