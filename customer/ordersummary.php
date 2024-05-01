<?php
session_start();
require "includes/dbconn.inc.php";
$userLogged = $_SESSION["userLogged"];
if ($userLogged && isset($_SESSION["ordersummary"])) {
    require "header.php";
} else {
    $_SESSION["userLogged"] = $userLogged;
    header("Location: login.php");
}
// Definisikan fungsi untuk memformat angka ke dalam mata uang
function formatCurrency($amount)
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function formatDistance($distance)
{
    return ceil($distance);
}

function formatDate($dateString)
{
    $date = DateTime::createFromFormat('YmdHis', $dateString);
    $formattedDate = $date->format('Y-m-d H:i:s');

    return $formattedDate;
}


include 'header.php';
$orderSummary = $_SESSION["ordersummary"];

$encryptedID = $orderSummary["encryptedID"];


$sql = "SELECT drivers_id
FROM orders
WHERE id= '$encryptedID'";
$stmt = mysqli_query($conn, $sql);
$driverID = "";
if ($stmt) {
    $row = mysqli_fetch_assoc($stmt);
    $driverID = $row["drivers_id"];
}



if ($driverID != "" && $driverID != null) {
    $sql2 = "SELECT*FROM drivers
    WHERE id = '$driverID'";
    $stmt2 = mysqli_query($conn, $sql2);
    if ($stmt2) {
        $row2 = mysqli_fetch_assoc($stmt2);
        $drivername = $row2["nama"];
        $driverplate = $row2["plat_nomor_kendaraan"];
    }
} else {
    $drivername = "Finding driver..";
    $driverplate = "Finding driver..";
}

?>
<div class="container container-login">
    <h1 style="text-align:center">Order Summary</h1>
    <br>

    <!-- Informasi Pesanan -->
    <div class="order-info">
        <p><strong>Invoice ID:</strong> <?php echo $orderSummary['id']; ?></p>
    </div>

    <!-- Informasi Perjalanan -->
    <div class="trip-info">
        <h2>Informasi Perjalanan</h2>
        <p><strong>Tanggal:</strong> <?php echo formatDate($orderSummary['tanggal']); ?></p>
        <p><strong>Lokasi Penjemputan:</strong> <?php echo $orderSummary['asal']; ?></p>
        <p><strong>Lokasi Tujuan:</strong> <?php echo $orderSummary['tujuan']; ?></p>
    </div>

    <!-- Informasi Pengemudi -->
    <div class="driver-info">
        <h2>Informasi Pengemudi</h2>
        <p><strong>Nama:</strong> <?php echo "$drivername"; ?></p>
        <p><strong>Kendaraan:</strong> <?php echo $orderSummary['layanan']; ?> </p>
        <p><strong>Plat Nomor:</strong> <?php echo "$driverplate"; ?></p>
    </div>

    <!-- Detail Tarif -->
    <div class="fare-details">
        <h2>Total</h2>
        <p><strong>Tarif Total:</strong> <?php echo formatCurrency($orderSummary["total"]); ?></p>
    </div>

    <!-- Detail Perjalanan -->
    <div class="trip-details">
        <h2>Detail Perjalanan</h2>
        <p><strong>Jarak:</strong> <?php echo formatDistance($orderSummary['distance']) . " km"; ?></p>
    </div>
</div>

<?php
// Sertakan file footer
include 'footer.php';
?>