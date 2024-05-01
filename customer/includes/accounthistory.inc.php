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
  $sql = "SELECT encryptionkey FROM keyCustomers WHERE customers_id= '$id'";
  $stmt = mysqli_query($conn, $sql);

  if ($stmt) {
    $row = mysqli_fetch_assoc($stmt);

    //get key
    $encryptionKey = $row["encryptionkey"];
    //query orders
    $sql2 = "SELECT * FROM orders WHERE id ='$id'";
    $stmt2 = mysqli_query($conn, $sql2);
    if ($stmt2) {
      while ($historyRow = mysqli_fetch_assoc($stmt2)) {
        $decryptedID = DataDecrypt($historyRow["id"], $encryptionKey);

        $historyTransaction = array(
          "id" => $decryptedID,
          "tarif" => $historyRow['tarif'],
          "tanggal" => $historyRow['tanggal'],
          "total" => $historyRow['total'],
          "asal" => $historyRow['asal'],
          "tujuan" => $historyRow['tujuan'],
          "diskon" => $historyRow['diskon'],
          "payment_method" => $historyRow['payment_method'],
          "notes" => $historyRow['notes'],
          "customers_id" => $historyRow['customers_id'],
          "drivers_id" => $historyRow['drivers_id'],
          "admins_id" => $historyRow['admins_id'],
          "layanans_id" => $historyRow['layanans_id']
        );
      }
      $_SESSION["historyTransaction"] = $historyTransaction;
      header("Location: ../accounthistory.php");
      exit();
    } else {
      echo "Error fetching history transaction: " . mysqli_error($conn);
    }
  } else {
    echo "Error fetching encryption key: " . mysqli_error($conn);
  }
} else {
  exit();
}
