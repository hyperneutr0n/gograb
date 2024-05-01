<?php
session_start();
include "dbconn.inc.php";
include "cryptographic.inc.php";

$order = array();

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
    $sql = "SELECT * FROM orders WHERE layanans_id = $id_layanan";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
        $row = mysqli_fetch_assoc($stmt);
        $customerID = $row["customers_id"];
        $invoiceID = $row["id"];

        // Ambil kunci enkripsi customer dari tabel keycustomer
        $sql2 = "SELECT*FROM customers WHERE id = '$customerID'";
        $stmt2 = mysqli_query($conn, $sql2);
        if ($stmt2) {
            $rowCustomer = mysqli_fetch_assoc($stmt2);
            $customerName = $rowCustomer["nama"];
            //echo $customerName;

            // Ambil kunci enkripsi order dari tabel keyOrder
            $sql3 = "SELECT encryptionKey FROM keyOrders WHERE orders_id = '$invoiceID'";
            $stmt3 = mysqli_query($conn, $sql3);
            if ($stmt3) {
                $rowKey = mysqli_fetch_assoc($stmt3);
                $orderEncryptionKey = $rowKey["encryptionKey"];

                //echo $orderEncryptionKey;



                $sql4 = "SELECT*FROM orders where layanans_id = $id_layanan";
                $stmt4 = mysqli_query($conn, $sql4);

                if ($stmt4) {

                    while ($innerrow = mysqli_fetch_assoc($stmt4)) {
                        // Dekripsi data pesanan
                        $decryptedID = DataDecrypt($innerrow["id"], $orderEncryptionKey);
                        $decryptedAsal = DataDecrypt($innerrow["asal"], $orderEncryptionKey);
                        $decryptedTujuan = DataDecrypt($innerrow["tujuan"], $orderEncryptionKey);


                        // echo $decryptedID;
                        // echo $decryptedAsal;
                        // echo $decryptedTujuan;


                        // Simpan data pesanan ke dalam array
                        $order[] = array(
                            "id" => $decryptedID,
                            "tarif" => $innerrow['tarif'],
                            "tanggal" => $innerrow['tanggal'],
                            "total" => $innerrow['total'],
                            "asal" => $decryptedAsal,
                            "tujuan" => $decryptedTujuan,
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
                    $_SESSION["order"] = $order;
                    // foreach ($order as $item) {
                    //     echo "ID: " . $item['id'] . "<br>";
                    //     echo "customer: " . $item['customers_id'] . "<br>";
                    //     // Repeat for other fields as needed
                    //     echo "<br>";
                    // }
                    header("Location: ../order.php");
                    exit();
                }
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
