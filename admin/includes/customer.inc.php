<?php
require "dbconn.inc.php";
include "cryptographic.inc.php";

$sql = "SELECT customers_id, encryptionkey FROM keycustomers";

$result = $conn->query($sql);
$customer_key = array();
while ($row = $result->fetch_assoc()) {
    $customer_key[] = $row;
}

echo "ID - NAMA - USERNAME - EMAIL - TELP<br/>";

$customer_data = array();

for ($i = 0; $i < count($customer_key); $i++) {
    echo $customer_key[$i]['customers_id'] . " - ";

    $sql2 = "SELECT * FROM customers WHERE id=?";
    $stmt2 = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt2, $sql2)) {
        mysqli_stmt_bind_param($stmt2, "s", $customer_key[$i]['customers_id']);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        if ($result2) {
            $row = mysqli_fetch_assoc($result2);

            $decryptedID = DataDecrypt($row["id"], $customer_key[$i]['encryptionkey']);
            $decryptedSaldo = DataDecrypt($row["saldo"], $customer_key[$i]['encryptionkey']);
            $decryptedNoTelp = DataDecrypt($row["no_telp"], $customer_key[$i]['encryptionkey']);

            $customerdetails = array(
                "id" => $decryptedID,
                "nama" => $row["nama"],
                "username" => $row["username"],
                "email" => $row["email"],
                "saldo" => $decryptedSaldo,
                "no_telp" => $decryptedNoTelp
            );
            $customer_data[$i] = $customerdetails;
            echo $customer_data[$i]['nama'] . " - " .
                $customer_data[$i]['nama'] . " - " .
                $customer_data[$i]['email'] . " - " .
                $customer_data[$i]['no_telp'] . "<br/>";
        }
    }
}
