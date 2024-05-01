<?php
session_start();
if (isset($_SESSION["adminLogged"]) && $_SESSION["adminLogged"] == true) {
  $adminLogged = true;
  require "header.php";
} else {
  header("Location: login.php");
}


require "includes/dbconn.inc.php";
include "includes/cryptographic.inc.php";

$sql = "SELECT drivers_id, encryptionkey FROM keydrivers";

$result = $conn->query($sql);
$driver_key = array();
while ($row = $result->fetch_assoc()) {
  $driver_key[] = $row;
}
$driver_data = array();

for ($i = 0; $i < count($driver_key); $i++) {

  $sql2 = "SELECT * FROM drivers WHERE id=?";
  $stmt2 = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt2, $sql2)) {
    mysqli_stmt_bind_param($stmt2, "s", $driver_key[$i]['drivers_id']);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if ($result2) {
      $row = mysqli_fetch_assoc($result2);

      $decryptedID = DataDecrypt($row["id"], $driver_key[$i]['encryptionkey']);
      $decryptedNoTelp = DataDecrypt($row["nomor_telp"], $driver_key[$i]['encryptionkey']);
      $decryptedNoKTP = DataDecrypt($row["nomor_ktp"], $driver_key[$i]['encryptionkey']);
      
      $driver_detail = array(
        "id" => $decryptedID,
        "nama" => $row["nama"],
        "username" => $row["username"],
        "email" => $row["email"],
        "no_telp" => "+62-" . $decryptedNoTelp,
        "no_ktp" => $decryptedNoKTP,
        "type" => $row["jenis_kendaraan"],
        "plate" => $row["plat_nomor_kendaraan"]
      );
      $driver_data[$i] = $driver_detail;
    }
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
        for ($i = 0; $i < count($driver_data); $i++) {
          echo "<tr>";
          foreach ($driver_data[$i] as $data) {
            echo "<td>";
            echo $data;
            echo "</td>";
          }
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>