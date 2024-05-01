<?php
session_start();
if (isset($_SESSION["adminLogged"]) && $_SESSION["adminLogged"] == true) {
  $adminLogged = true;
  //require "header.php";
} else {
  header("Location: login.php");
}


require "includes/dbconn.inc.php";
require "includes/cryptographic.inc.php";

$sql = "SELECT*FROM drivers";
$stmt = mysqli_query($conn, $sql);


if ($stmt) {
  while ($rowDrivers = mysqli_fetch_assoc($stmt)) {
    $sql2 = "SELECT*FROM keydrivers WHERE
    drivers_id='{$rowDrivers['id']}'";
    $stmt2 = mysqli_query($conn, $sql2);
    if ($stmt2) {
      $rowKey = mysqli_fetch_assoc($stmt2);
      $encryptionKey = $rowKey["encryptionkey"];
    }

    
    $driver_detail[] = array(
      "encryption_key" => $encryptionKey,
      "id" => $rowDrivers["id"],
      "nama" => $rowDrivers["nama"],
      "username" => $rowDrivers["username"],
      "email" => $rowDrivers["email"],
      "notelp" => $rowDrivers["nomor_telp"],
      "noktp" => $rowDrivers["nomor_ktp"],
      "type" => $rowDrivers["jenis_kendaraan"],
      "plate" => $rowDrivers["plat_nomor_kendaraan"]
    );
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Customer</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <br>
    <br>
    <h2>Data Driver</h2>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th>Nomor Telepon</th>
          <th>Nomor KTP</th>
          <th>Jenis Kendaraan</th>
          <th>Plat Nomor Kendaraan</th>
        </tr>
      </thead>
      <tbody>
        <?php

        foreach ($driver_detail as $drivers) {
          echo "<tr>";

          echo "<td>";
          echo DataDecrypt($drivers['id'], $drivers["encryption_key"]);
          echo "</td>";

          echo "<td>";
          echo $drivers["nama"];
          echo "</td>";

          echo "<td>";
          echo $drivers["username"];
          echo "</td>";

          echo "<td>";
          echo $drivers["email"];
          echo "</td>";

          echo "<td>";
          echo DataDecrypt($drivers["notelp"], $drivers["encryption_key"]);
          echo "</td>";

          echo "<td>";
          echo DataDecrypt($drivers["noktp"], $drivers["encryption_key"]);
          echo "</td>";

          echo "<td>";
          echo $drivers["type"];
          echo "</td>";

          echo "<td>";
          echo $drivers["plate"]; 
          echo "</td>";


          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>