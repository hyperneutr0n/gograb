<?php
session_start();
if (isset($_SESSION["adminLogged"]) && $_SESSION["adminLogged"] == true) {
  $adminLogged = true;
  require "header.php";
} else {
  header("Location: login.php");
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
  <h2>Data Driver</h2>
  <div class="container mt-5">
    <h2>Data Customer</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th>Password</th>
          <th>Saldo</th>
          <th>Nomor Telepon</th>
          <th>Nomor KTP</th>
          <th>Jenis Kendaraan</th>
          <th>Plat Nomor Kendaraan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>johndoe</td>
          <td>johndoe@example.com</td>
          <td>********</td>
          <td>$100</td>
          <td>1234567890</td>
          <td>1234567890123456</td>
          <td>Motor</td>
          <td>AB 1234 CD</td>
        </tr>
        <tr>
          <td>Jane Doe</td>
          <td>janedoe</td>
          <td>janedoe@example.com</td>
          <td>********</td>
          <td>$150</td>
          <td>0987654321</td>
          <td>9876543210987654</td>
          <td>Mobil</td>
          <td>XYZ 5678 EF</td>
        </tr>
        <tr>
          <td>Michael Smith</td>
          <td>mikesmith</td>
          <td>mikesmith@example.com</td>
          <td>********</td>
          <td>$75</td>
          <td>9876543210</td>
          <td>4567890123456789</td>
          <td>Motor</td>
          <td>CD 5678 EF</td>
        </tr>
        <tr>
          <td>Emily Johnson</td>
          <td>emilyjohnson</td>
          <td>emilyjohnson@example.com</td>
          <td>********</td>
          <td>$200</td>
          <td>1230987654</td>
          <td>7890123456789012</td>
          <td>Mobil</td>
          <td>FGH 1234 KL</td>
        </tr>
        <!-- Tambahkan data customer lainnya sesuai kebutuhan -->
      </tbody>
    </table>
  </div>
</body>

</html>