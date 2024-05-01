<?php
session_start();
if (isset($_POST["submit"])) {
  $id = $_POST["invoice_id"];


  require "includes/dbconn.inc.php";
  require "includes/cryptographic.inc.php";


  $sql2 = "SELECT*FROM keyorders WHERE orders_id = '$id'";
  $stmt2 = mysqli_query($conn, $sql2);

  $sql4 = "SELECT drivers_id FROM orders WHERE id = '$id'";
  $stmt4 = mysqli_query($conn, $sql4);



  if ($stmt4) {
    $rowDriverFromOrders = mysqli_fetch_assoc($stmt4);
    $driverID = $rowDriverFromOrders["drivers_id"];

    $sql5 = "SELECT*FROM drivers WHERE id = '$driverID'";
    $stmt5 = mysqli_query($conn, $sql5);

    if ($stmt5) {
      $rowDriver = mysqli_fetch_assoc($stmt5);
      $nama = $rowDriver["nama"];
      $plat = $rowDriver["plat_nomor_kendaraan"];

      $jenis_kendaraan = $rowDriver["jenis_kendaraan"];
    }
  }

  if ($stmt2) {
    $rowKey = mysqli_fetch_assoc($stmt2);
    $encryptionKey = $rowKey["encryptionkey"];

    $sql = "SELECT*FROM orders WHERE id = '$id'";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
      $decryptedID = DataDecrypt($id, $encryptionKey);
      $row = mysqli_fetch_assoc($stmt);
      $tanggal = $row["tanggal"];
      $total = $row["total"];
      $asal = DataDecrypt($row["asal"], $encryptionKey);
      $tujuan = DataDecrypt($row["tujuan"], $encryptionKey);
      $customerID = $row["customers_id"];

      $sql3 = "SELECT*FROM customers WHERE id='$customerID'";
      $stmt3 = mysqli_query($conn, $sql3);
      if ($stmt3) {
        $rowCustomer = mysqli_fetch_assoc($stmt3);
      } else {
        echo mysqli_error($conn);
      }
    } else {
      echo mysqli_error($conn);
    }
  } else {
    echo mysqli_error($conn);
  }
  $clicked = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    h1 {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
    }

    h2 {
      padding-left: 20vw;
    }

    p {
      padding-left: 20vw;
    }

    /* a {

      padding-left: 47vw;

    } */
    @media print {
      #printButton {
        display: none;
      }
    }

    #printButton {
      margin-left: 47vw;
    }
  </style>
</head>

<body>

  <div class="container container-login justify-content-center">
    <h1 class="text-center">Order Summary</h1>
    <br>

    <div class="order-info">
      <h2><strong>Invoice ID:</strong> <?php echo $decryptedID; ?></h2>
    </div>

    <div class="trip-info">
      <h2>Informasi Perjalanan</h2>
      <p><strong>Tanggal:</strong> <?php echo $tanggal; ?></p>
      <p><strong>Lokasi Penjemputan:</strong> <?php echo $asal; ?></p>
      <p><strong>Lokasi Tujuan:</strong> <?php echo $tujuan; ?></p>
    </div>

    <div class="driver-info">
      <h2>Informasi Pengemudi</h2>
      <p><strong>Nama:</strong> <?php echo "$nama"; ?></p>
      <p><strong>Kendaraan:</strong> <?php echo "$jenis_kendaraan"; ?> </p>
      <p><strong>Plat Nomor:</strong> <?php echo "$plat"; ?></p>
    </div>

    <div class="fare-details">
      <h2><strong>Total:</strong> <?php echo "$total"; ?></h2>
    </div>

    <br>
    <br>
    <br>
  </div>

  <button id="printButton" onclick="window.print()" class="btn btn-primary">Print</button>

</body>

</html>