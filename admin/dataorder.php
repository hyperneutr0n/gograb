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

$sql = "SELECT orders_id, encryptionkey FROM keyorders";

$result = $conn->query($sql);
$order_key = array();
while ($row = $result->fetch_assoc()) {
  $order_key[] = $row;
}
$order_data = array();

function formatDate($dateString)
{
  $date = DateTime::createFromFormat('YmdHis', $dateString);
  $formattedDate = $date->format('Y-m-d H:i:s');

  return $formattedDate;
}

for ($i = 0; $i < count($order_key); $i++) {

  $sql2 = "SELECT * FROM orders WHERE id=?";
  $stmt2 = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt2, $sql2)) {
    mysqli_stmt_bind_param($stmt2, "s", $order_key[$i]['customers_id']);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if ($result2) {
      $row = mysqli_fetch_assoc($result2);

      $decryptedID = DataDecrypt($row["id"], $order_key[$i]['encryptionkey']);
      $formattedDate = formatDate($row['tanggal']);
      $decryptedAsal = DataDecrypt($row["asal"], $order_key[$i]['encryptionkey']);
      $decryptedTujuan = DataDecrypt($row["tujuan"], $order_key[$i]['encryptionkey']);

      $sql3 = "SELECT nama FROM customers WHERE id=?";
      $stmt3 = mysqli_stmt_init($conn);
      $cust_row = array();
      if (mysqli_stmt_prepare($stmt3, $sql3)) {
        mysqli_stmt_bind_param($stmt3, "s", $row['customers_id']);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        if ($result3) {
          $cust_row = mysqli_fetch_assoc($result3);
        }
      }

      $sql4 = "SELECT nama FROM drivers WHERE id=?";
      $stmt4 = mysqli_stmt_init($conn);
      $drv_row = array();
      if (mysqli_stmt_prepare($stmt4, $sql4)) {
        mysqli_stmt_bind_param($stmt4, "s", $row['drivers_id']);
        mysqli_stmt_execute($stmt4);
        $result4 = mysqli_stmt_get_result($stmt4);
        if ($result4) {
          $drv_row = mysqli_fetch_assoc($result4);
        }
      }

      $sql5 = "SELECT nama FROM admins WHERE id=?";
      $stmt5 = mysqli_stmt_init($conn);
      $adm_row = array();
      if (mysqli_stmt_prepare($stmt5, $sql5)) {
        mysqli_stmt_bind_param($stmt5, "s", $row['admins_id']);
        mysqli_stmt_execute($stmt5);
        $result5 = mysqli_stmt_get_result($stmt5);
        if ($result5) {
          $adm_row = mysqli_fetch_assoc($result5);
        }
      }

      $order_status = "NOT DONE";
      if ($row["order_finished"] == 1) $order_status = "DONE";

      $customerdetails = array(
        "id" => $decryptedID,
        "tarif" => $row["tarif"],
        "tanggal" => $formattedDate,
        "total" => $row["total"],
        "asal" => $decryptedAsal,
        "tujuan" => $decryptedTujuan,
        "notes" => $row["notes"],
        "customer" => $cust_row["nama"],
        "driver" => $drv_row["nama"],
        "status" => $order_status
      );
      $order_data[$i] = $customerdetails;
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
    <h2>Data Order</h2>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tarif</th>
          <th>Tanggal</th>
          <th>Asal</th>
          <th>Tujuan</th>
          <th>Notes</th>
          <th>Nama Customer</th>
          <th>Nama Driver</th>
          <th>Nama Admin</th>
        </tr>
      </thead>
      <tbody>
        <?php
        for ($i = 0; $i < count($order_data); $i++) {
          echo "<tr>";
          foreach ($order_data[$i] as $data) {
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