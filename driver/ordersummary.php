<?php
session_start();
require "includes/dbconn.inc.php";
require "includes/cryptographic.inc.php";
$driverLogged = $_SESSION["driverLogged"];
$id = "";

if ($driverLogged && isset($_SESSION["invoiceID"])) {
    $id = $_SESSION["invoiceID"];
    require "header.php";
} else {
    header("Location: order.php");
}

$driverID = $_SESSION["driverId"];
$sql4 = "SELECT*FROM drivers where id = '$driverID'";
$stmt4 = mysqli_query($conn, $sql4);


if ($stmt4) {
    $rowDriver = mysqli_fetch_assoc($stmt4);
    $nama = $rowDriver["nama"];
    $jenis_kendaraan = $_SESSION["kendaraan"];
    $plat = $rowDriver["plat_nomor_kendaraan"];
}



$sql2 = "SELECT*FROM keyorders WHERE orders_id = '$id'";
$stmt2 = mysqli_query($conn, $sql2);

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


if(isset($_POST["submit"])){
    unset($_SESSION["invoiceID"]);
    unset($_SESSION["ordersummary"]);
    header("Location: includes/order.inc.php");
}



?>
<div class="container container-login">
<h1 class="text-center">Order Summary</h1>
<br>

<div class="order-info">
    <p><strong>Invoice ID:</strong> <?php echo $decryptedID; ?></p>
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
    <h2>Total</h2>
    <p><strong>Tarif Total:</strong> <?php echo "$total"; ?></p>
</div>
<form action="" method="POST" class="text-center">
    <button type="submit" name="submit" class="btn btn-primary bg-dark">Order Finished</button>
    <br>
    <br>
    <br>

</form>
</div>

<?php require "footer.php";?>
