<?php
session_start();
require "includes/dbconn.inc.php";
$driverLogged = $_SESSION["driverLogged"];

if ($driverLogged) {
    require "header.php";
} else {
    header("Location: order.php");
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