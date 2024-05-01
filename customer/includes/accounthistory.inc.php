<?php
session_start();
include "dbconn.inc.php";
include "cryptographic.inc.php";

//store history 
$historyTransaction = array();

if (isset($_SESSION["userLogged"]) && $_SESSION["userLogged"] == true) {
  $id =  $_SESSION["userid"];
  echo "User ID: $id";

  //query encryption key nya customer
  $sql = "SELECT * FROM orders WHERE customers_id ='$id'";
  $stmt = mysqli_query($conn, $sql);

  if ($stmt) {
    while ($row = mysqli_fetch_assoc($stmt)) {
      $orderID = $row["id"];

      //query encryption key nya order
      $sql2 = "SELECT encryptionkey FROM keyOrders WHERE orders_id= '$orderID'";
      $stmt2 = mysqli_query($conn, $sql2);

      if ($stmt2) {
        $encryptionRow = mysqli_fetch_assoc($stmt2);
        $encryptionKey = $encryptionRow["encryptionkey"];

        //echo "Encryption Key: $encryptionKey";

        $decryptedID = DataDecrypt($row["id"], $encryptionKey);
        $decryptedAsal = DataDecrypt($row["asal"], $encryptionKey);
        $decryptedTujuan = DataDecrypt($row["tujuan"], $encryptionKey);

        $historyTransaction[] = array(
          "encryptedID" => $orderID,
          "id" => $decryptedID,
          "tarif" => $row['tarif'],
          "tanggal" => $row['tanggal'],
          "total" => $row['total'],
          "asal" => $decryptedAsal,
          "tujuan" => $decryptedTujuan,
          "diskon" => $row['diskon'],
          "payment_method" => $row['payment_method'],
          "notes" => $row['notes'],
          "customers_id" => $row['customers_id'],
          "drivers_id" => $row['drivers_id'],
          "admins_id" => $row['admins_id'],
          "layanans_id" => $row['layanans_id']
        );
      } else {
        echo "Error fetching encryption key: " . mysqli_error($conn);
      }
    }

    $_SESSION["historyTransaction"] = $historyTransaction;
    // foreach ($historyTransaction as $orders) {
    //   echo "INVOICE: " . $orders["id"] . "<br>";
    //   echo "Asal: " . $orders["asal"] . "<br>";
    //   echo "Tujuan: " . $orders["tujuan"] . "<br>";
    //   echo "<br>";
    // }

    header("Location: ../accounthistory.php");
    exit();
  } else {
    echo "Error fetching orders: " . mysqli_error($conn);
  }
} else {
  exit();
}
